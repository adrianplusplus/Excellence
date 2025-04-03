class Search{
    constructor(){
        this.searchPanelHTML();
        this.searchIcon = document.querySelector(".search-icon");
        this.cancelIcon = document.querySelector(".search-panel-close-icon");
        this.searchPanel = document.querySelector(".search-panel");
        this.searchInput = document.querySelector("#search-query");
        this.searchResults = document.querySelector("#search-results");
        this.isSearchOpen = false;
        this.isSpinning = false;
        this.typingTimer;
        this.prevSearchString;
        this.events();
    }   
     
    events(){
        this.searchIcon.addEventListener("click", this.openSearchPanel.bind(this));
        this.cancelIcon.addEventListener("click", this.closeSearchPanel.bind(this));
        document.addEventListener("keyup", this.keyPressed.bind(this));        
        this.searchInput.addEventListener("keyup", this.handleSearchQuery.bind(this));
    }

    openSearchPanel(){
        console.log("search panel open");
        this.searchPanel.classList.add("search-panel-visible");
        document.body.classList.add("disable-scroll");
        this.searchInput.value="";
        this.searchInput.focus();
        this.searchResults.innerHTML ='';
        this.isSearchOpen = true;
    }

    closeSearchPanel(){
        this.searchPanel.classList.remove("search-panel-visible");
        document.body.classList.remove("disable-scroll");
        this.isSearchOpen = false;
    }

    keyPressed(e){
        if(e.keyCode == 83){
            var inputElems = ['input', 'textarea'];
            if (!this.isSearchOpen && (inputElems.indexOf(document.activeElement.tagName.toLowerCase()) == -1)) {
                this.openSearchPanel();
            }
        }            
        if(e.keyCode == 27){
            if(this.isSearchOpen)
                this.closeSearchPanel();
        }
    }
    handleSearchQuery(){
        console.log(this.prevSearchString);
        if(this.searchInput.value != this.prevSearchString){
            clearTimeout(this.typingTimer);
            if(this.searchInput.value){
                if(!this.isSpinning){
                    this.searchResults.innerHTML = '<div class="loading"></div>';
                    this.isSpinning = true;
                }
                this.typingTimer = setTimeout( this.sendSearchRequest.bind(this), 1000);
            }
            else{
                this.searchResults.innerHTML = '';  //clear out the results area
                this.isSpinning = false;
            }               
        }        
        this.prevSearchString = this.searchInput.value;
    }

    sendSearchRequest(){
        this.isSpinning = false;
        Promise.all([
            fetch(siteData.root_url+ '/wp-json/wp/v2/posts?search='+this.searchInput.value).then(resp => resp.json()),
            fetch(siteData.root_url+ '/wp-json/wp/v2/pages?search='+this.searchInput.value).then(resp => resp.json()),
            fetch(siteData.root_url+ '/wp-json/wp/v2/event?search='+this.searchInput.value).then(resp => resp.json()),
            fetch(siteData.root_url+ '/wp-json/wp/v2/course?search='+this.searchInput.value).then(resp => resp.json()),
            fetch(siteData.root_url+ '/wp-json/wp/v2/teacher?search='+this.searchInput.value).then(resp => resp.json())
          ]).then((data)=>{
            let combinedResults = data[0].concat(data[1], data[2] ,data[3], data[4]);
            if(combinedResults.length){
                this.searchResults.innerHTML =`
                <div class="results-container">
                    <h2 class="search-results-title">Results</h2>
                        <ul class = "search-results-list">
                        ${combinedResults.map(element=> 
                            `<li><a href="${element.link}">${element.title.rendered}</a> by ${element.author_name}</li></li>`
                            ).join('')} 
                    </ul>
                </div>
                `;  ``
            }
            else{
                this.searchResults.innerHTML = `
                <div class="results-container">
                    <h2 class="search-results-title">Results</h2>
                    <p>No items matched your search</p>
                </div>
                `;    
            }    
        }).catch(() =>{
            this.searchResults.innerHTML = `
                <div class="results-container">
                    <h2 class="search-results-title">Results</h2>
                    <p>An unexpected error occured!</p>
                </div>
                `;
        });

    }
    
    searchPanelHTML(){
        var searchDiv = document.createElement('div');
        searchDiv.classList.add("search-panel");
        searchDiv.innerHTML = `
            <div class="search-panel-input">
                <i class="fa fa-search search-panel-search-icon" aria-hidden="true"></i>
                <input type="text" class="search-query" placeholder="Search here..." id="search-query">
                <i class="fa fa-window-close search-panel-close-icon" aria-hidden="true"></i>
            </div>
            <div id="search-results" class="container">
                <div class="results-container"></div>      
            </div>
        `;
        document.body.appendChild(searchDiv);
    }
}
export default Search
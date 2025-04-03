class Search {
  constructor() {
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
  events() {
    this.searchIcon.addEventListener("click", this.openSearchPanel.bind(this));
    this.cancelIcon.addEventListener("click", this.closeSearchPanel.bind(this));
    document.addEventListener("keyup", this.keyPressed.bind(this));
    this.searchInput.addEventListener(
      "keyup",
      this.handleSearchQuery.bind(this)
    );
  }
  openSearchPanel() {
    console.log("search panel open");
    this.searchPanel.classList.add("search-panel-visible");
    document.body.classList.add("disable-scroll");
    this.searchInput.value = "";
    this.searchInput.focus();
    this.searchResults.innerHTML = "";
    this.isSearchOpen = true;
  }
  closeSearchPanel() {
    this.searchPanel.classList.remove("search-panel-visible");
    document.body.classList.remove("disable-scroll");
    this.isSearchOpen = false;
  }
  keyPressed(e) {
    if (e.keyCode == 83) {
      var inputElems = ["input", "textarea"];
      if (
        !this.isSearchOpen &&
        inputElems.indexOf(document.activeElement.tagName.toLowerCase()) == -1
      ) {
        this.openSearchPanel();
      }
    }
    if (e.keyCode == 27) {
      if (this.isSearchOpen) this.closeSearchPanel();
    }
  }
  handleSearchQuery() {
    console.log(this.prevSearchString);
    if (this.searchInput.value != this.prevSearchString) {
      clearTimeout(this.typingTimer);
      if (this.searchInput.value) {
        if (!this.isSpinning) {
          this.searchResults.innerHTML = '<div class="loading"></div>';
          this.isSpinning = true;
        }
        this.typingTimer = setTimeout(this.sendSearchRequest.bind(this), 1000);
      } else {
        this.searchResults.innerHTML = ""; //clear out the results area
        this.isSpinning = false;
      }
    }
    this.prevSearchString = this.searchInput.value;
  }

  sendSearchRequest() {
    console.log(
      siteData.root_url +
        "/wp-json/excellence/v1/search?term=" +
        this.searchInput.value
    );
    fetch(
      siteData.root_url +
        "/wp-json/excellence/v1/search?term=" +
        this.searchInput.value
    )
      .then((response) => {
        return response.json();
      })
      .then((data) => {
        if (
          data.posts.length ||
          data.pages.length ||
          data.courses.length ||
          data.teachers.length ||
          data.events.length
        ) {
          this.searchResults.innerHTML = `
              <div class="results-container">
                  <div class="results-column">
                      <h3 class="search-results-title">Blog Posts</h3>
                      ${
                        data.posts.length
                          ? '<ul class = "list-item">'
                          : "<p>No posts matched your search</p>"
                      }
                      ${data.posts
                        .map(
                          (element) => `
                              <li class="results-heading"><a href= "${element.permalink}"> ${element.title} </a> by ${element.author_name}</li>`
                        )
                        .join("")}
                      ${data.posts.length ? "</ul>" : ""}
                      
                      <h3 class="search-results-title">Pages</h3>
                      ${
                        data.pages.length
                          ? '<ul class = "list-item"> '
                          : "<p>No pages matched your search</p>"
                      }
                      ${data.pages
                        .map(
                          (element) => `
                              <li class="results-heading"><a href= "${element.permalink}"> ${element.title} </a></li>`
                        )
                        .join("")}
                      ${data.pages.length ? "</ul>" : ""}

                      <h3 class="search-results-title">Courses</h3>
                          ${
                            data.courses.length
                              ? '<ul class = "list-item">'
                              : "<p>No courses matched your search</p>"
                          }
                          ${data.courses
                            .map(
                              (element) => `
                                  <li class="results-heading"><a href= "${element.permalink}"> ${element.title} </a></li>`
                            )
                            .join("")}
                          ${data.courses.length ? "</ul>" : ""}
                  </div>

                  <div class="results-column">
                      <h3 class="search-results-title">Teachers</h3>
                          ${
                            data.teachers.length
                              ? '<ul class = "results-page-flex">'
                              : "<p>No teachers matched your search.</p>"
                          }
                              ${data.teachers
                                .map(
                                  (element) => `
                              <li class="results-teacher-image">
                                  <a href="${element.permalink}">
                                      <img src="${element.image}" alt="">
                                      <h1 class="results-heading">${element.title}</h1>
                                  </a>
                              </li>
                              `
                                )
                                .join("")}
                          ${data.teachers.length ? "</ul>" : ""}
                      
                      <h3 class="search-results-title">Events</h3>
                          ${
                            data.events.length
                              ? ""
                              : "<p>No events matched your search</p>"
                          }
                          ${data.events
                            .map(
                              (element) => `
                              <div class="event">
                                  <a class="event-date" href="${element.permalink}">
                                      <span class="month">${element.month}</span>
                                      <span class="day">${element.date}</span>
                                  </a>
                                  <div class="content">
                                      <h1 class="results-heading"><a href="${element.permalink}">${element.title}</a></h1>
                                      <p class="event-discription">${element.excerpt}
                                          <a href="${element.permalink}" class="link-blue">Learn more</a>
                                      </p>
                                  </div>
                              </div>
                                  `
                            )
                            .join("")}                                    
                  </div>
              </div>
              `;
        } else {
          this.searchResults.innerHTML = `
              <div class="results-container">
                  <h2 class="search-results-title">Results</h2>
                  <p>No items matched your search</p>
              </div>
              `;
        }
      });
    this.isSpinning = false;
  }

  searchPanelHTML() {
    var searchDiv = document.createElement("div");
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
export default Search;

import $ from 'jquery';

class Search {

    constructor() {
        this.addSearchHtml();

        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.searchField = $("#search-term");
        this.resultsDiv = $("#search-overlay__results");

        this.previousValue = undefined;

        this.isOverlayOpen = false;
        this.isSpinnerVisible = false;
        this.events();
    }

    addSearchHtml() {
        $("body").append(`
            <div class="search-overlay">
                <div class="search-overlay__top">
                    <div class="container">
                        <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                        <input type="text" class="search-term" placeholder="What are you looking for" id="search-term">
                        <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
                    </div>
                </div>
    
                <div class="container">
                    <div id="search-overlay__results"></div>
                </div>
            </div>
        `);
    }

    events() {
        this.openButton.on('click', this.openOverlay.bind(this));
        this.closeButton.on('click', this.closeOverlay.bind(this));

        $(document).on('keydown', this.keyPressDispatcher.bind(this));

        this.searchField.on('keyup', this.typingLogic.bind(this));
    }

    openOverlay() {
        this.searchOverlay.addClass('search-overlay--active');
        $("body").addClass('body-no-scroll');
        this.searchField.val('');
        setTimeout( () => {
            this.searchField.focus()
        } , 301);
        this.isOverlayOpen = true;
    }

    closeOverlay() {
        this.searchOverlay.removeClass('search-overlay--active');
        $("body").removeClass('body-no-scroll');
        this.isOverlayOpen = false;
    }

    keyPressDispatcher(e) {
        if (e.keyCode === 83 && !this.isOverlayOpen && !$("input, textarea").is(':focus')) {
            this.openOverlay();
        } else if (e.keyCode === 27 && this.isOverlayOpen) {
            this.closeOverlay();
        }
    }

    typingLogic() {
        if (this.previousValue !== this.searchField.val()) {
            clearTimeout(this.typingTimer);
            if (this.searchField.val()) {
                if (!this.isSpinnerVisible) {
                    this.isSpinnerVisible = true;
                    this.resultsDiv.html('<div class="spinner-loader"></div>');
                }
                this.typingTimer = setTimeout(this.getResults.bind(this) , 500);

            } else {
                this.resultsDiv.html('');
                this.isSpinnerVisible = false;
            }

            this.previousValue = this.searchField.val();
        }
    }

    getResults() {
        const searchField = this.searchField.val();
        const rootUrl = universityData.root_url;

        $.when(
            $.getJSON(rootUrl + '/wp-json/wp/v2/posts?search=' + searchField),
            $.getJSON(rootUrl + '/wp-json/wp/v2/pages?search=' + searchField)
        ).then((posts, pages) => {
                const results = posts[0].concat(pages[0]);
                this.resultsDiv.html(`
                    <h2 class="search-overlay__title">General information</h2>
                    ${results.length ? '<ul class="link-list min-list">' : '<p>No match</p>'}
                        ${results.map(result => `
                            <li>
                                <a href="${result.link}">${result.title.rendered}</a>
                                ${result.type === 'post' ? `by ${result.author_name}` : ''}
                            </li>
                        `).join('')}
                    ${results.length ? '</ul>' : ''}
                `);
                this.isSpinnerVisible = false;
        }, () => {
            this.resultsDiv.html('<p>an error has occurred</p>')
        });
    }
}

export default Search;

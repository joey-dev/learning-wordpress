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
        return false;
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
        const url = rootUrl +  '/wp-json/university/v1/search?term=';

        $.getJSON(url + searchField, (results) => {
            console.log(results.generalInfo);
            this.resultsDiv.html(`
                <div class="row">
                    <div class="one-third">
                        <h2>General information</h2>
                        ${results.generalInfo.length ? '<ul class="link-list min-list">' : '<p>No match</p>'}
                            ${results.generalInfo.map(result => `
                                <li>
                                    <a href="${result.permalink}">${result.title}</a>
                                    ${result.postType === 'post' ? `by ${result.author_name}` : ''}
                                </li>
                            `).join('')}
                        ${results.generalInfo.length ? '</ul>' : ''}
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__title">Programs</h2>
                        ${results.programs.length ? '<ul class="link-list min-list">' : '<p>No match</p>'}
                            ${results.programs.map(result => `
                                <li>
                                    <a href="${result.permalink}">${result.title}</a>
                                </li>
                            `).join('')}
                        ${results.programs.length ? '</ul>' : ''}
                        <h2 class="search-overlay__title">Professors</h2>
                        ${results.professors.length ? '<ul class="professor-cards">' : '<p>No match</p>'}
                            ${results.professors.map(result => `
                                <li class="professor-card__list-item">
                                    <a class="professor-card" href="${result.permalink}">
                                        <img src="${result.image}" class="professor-card__image">
                                        <span class="professor-card__name">
                                            ${result.title}
                                        </span>
                                    </a>
                                </li>
                            `).join('')}
                        ${results.professors.length ? '</ul>' : ''}
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__title">Campuses</h2>
                        <p>No match</p>
                        <h2 class="search-overlay__title">Events</h2>
                        ${results.events.length ? '' : '<p>No match</p>'}
                            ${results.events.map(result => `
                                <div class="event-summary">
                                    <a class="event-summary__date t-center" href="${result.permalink}">
                                        <span class="event-summary__month">
                                            ${result.month}
                                        </span>
                                        <span class="event-summary__day">
                                            ${result.day}
                                        </span>
                                    </a>
                                    <div class="event-summary__content">
                                        <h5 class="event-summary__title headline headline--tiny">
                                            <a href="<?= get_the_permalink(); ?>">
                                                ${result.title}
                                            </a>
                                        </h5>
                                        <p>
                                            ${result.description}
                                            <a href="${result.permalink}" class="nu gray">
                                                Learn more
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            `).join('')}
                    <div>
                </div>
            `)
            this.isSpinnerVisible = false;
        });
    }
}

export default Search;

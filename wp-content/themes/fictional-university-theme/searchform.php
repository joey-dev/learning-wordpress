<div class="generic-content">
    <form method="get" class="search-form" action="<?= esc_url(site_url('/')); ?>">
        <label class="headline headline--medium" for="s">Perform a new search</label>
        <div class="search-form-row">
            <input class="s" type="search" id="s" name="s" placeholder="what are you looking for?">
            <input class="search-submit" type="submit" value="Search">
        </div>
    </form>
</div>
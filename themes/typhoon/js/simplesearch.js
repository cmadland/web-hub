((function(global) {
  global.simpleSearchData = function(settings = {}) {
    return {
      query: settings.query || '',
      autocomplete: settings.autocomplete || 0,
      url: settings.url || '',
      separator: settings.separator || '',
      searchResults: [],
      showResults: false,
      hasResults: function() {
        return this.showResults;
      },
      show: function() {
        this.showResults = true;
      },
      hide: function() {
        this.showResults = false;
      },
      search: function($event) {
        const isValid = $event.target.min ? $event.target.value.length >= $event.target.min : true;
        const value = $event.target.value;

        if (!isValid || !this.autocomplete) {
          this.hide();
          return true;
        }

        if ($event.key === 'Enter') {
          $event.stopPropagation();
          $event.preventDefault();
        }

        fetch(`${this.url}${this.separator}${value}`)
          .then(response => response.json())
          .then(data => {
            this.searchResults = data

            if (isValid && this.searchResults.length) {
              this.show();
            } else {
              this.hide();
            }
          });
      }
    }
  };
})(window));

jQuery(document).ready(function($) {
	
if (typeof Joomla === 'undefined' || typeof Joomla.getOptions === 'undefined') {
	console.error('Joomla.getOptions not found!\nThe Joomla core.js file is not being loaded.');
	return false;
}
var options = Joomla.getOptions('cg_dictionary');
if (typeof options === 'undefined' ) {return false}

items = document.querySelector(".isotope_grid").querySelectorAll(".isotope_item");
items_width =  ((100 / parseInt(options.nbcol)) - 1)+"%";
for (i = 0; i < items.length; i++) {
    items[i].style.width = items_width;
	if (options.nbcol > 1) items[i].style.marginRight = "1%";
	if (options.defhidden == "false") {
		items[i].style.display = "inline-grid";
		items[i].style.gridTemplateColumns ="7em auto 6em";
	} else if (options.defhidden == "hover"){
		
		item_text = items[i].querySelector('.cg_text');
		if (item_text) {
			item_text.style.display = "none";
		}
	}
}
var qsRegex_sigle,qsRegex_text
var filters = ['*']
var $grid = jQuery('.isotope_grid').imagesLoaded( 
   function() {
	$grid.isotope({ 
     itemSelector: '.isotope_item',
     percentPosition: true,
  	 layoutMode:'masonry',
  getSortData: {  },
  filter: function() {
    var $this = jQuery(this);
    var searchResult_sigle = qsRegex_sigle ? $this.attr('data-word').match( qsRegex_sigle ) : true;
    var searchResult_text = qsRegex_text ? $this.text().match( qsRegex_text ) : true;
	var laclasse = $this.attr('class');
	var lescles = laclasse.split(" ");
	var buttonResult = false;
	if (filters.indexOf('*') != -1) { buttonResult = true};
	for (var i in lescles) {
		if (filters.indexOf(lescles[i]) != -1) {
			buttonResult = true;
		}
	}
    return searchResult_sigle && searchResult_text && buttonResult;
  }
 });
});	

// use value of search field to filter
var $quicksearch_sigle = jQuery('.quicksearch_sigle').keyup( debounce( function() {
  qsRegex_sigle = new RegExp( $quicksearch_sigle.val(), 'gi' );
  $grid.isotope();
}) );
jQuery('.quicksearch_text').focusin( function() {
	jQuery('.quicksearch_sigle').val("");
  qsRegex_sigle = new RegExp( $quicksearch_sigle.val(), 'gi' );
  $grid.isotope();
});
jQuery('.quicksearch_sigle').focusin( function() {
	jQuery('.quicksearch_text').val("");
  qsRegex_text = new RegExp( $quicksearch_text.val(), 'gi' );
  $grid.isotope();
	
});
var $quicksearch_text = jQuery('.quicksearch_text').keyup( debounce( function() {
  qsRegex_text = new RegExp( $quicksearch_text.val(), 'gi' );
  $grid.isotope();
}) );

// debounce so filtering doesn't happen every millisecond
function debounce( fn, threshold ) {
  var timeout;
  return function debounced() {
    if ( timeout ) {
      clearTimeout( timeout );
    }
    function delayed() {
      fn();
      timeout = null;
    }
    timeout = setTimeout( delayed, threshold || 100 );
  }  
}

cg_a = document.querySelectorAll(".cg_a");
for (i = 0; i < cg_a.length; i++) {
    cg_a[i].addEventListener("click", (event) => {
		if (options.defhidden != "click") return true;
		$ix = event.currentTarget.attributes['data-target'].value;
		a_text = document.querySelector('#'+$ix)
		a_text.classList.toggle('active')
		a_parent = event.currentTarget.parentElement;
		a_parent.classList.toggle('active');
		active = document.querySelector(".isotope_grid").querySelectorAll(".active");
		for (a = 0; a < active.length; a++) {
			if ((active[a] != a_parent) && (active[a] != a_text)) {
				active[a].classList.remove('active');
				if (active[a].children[1]) active[a].children[1].classList.remove('active');
			}
		}
	});
}
cg_text = document.querySelectorAll(".cg_text");
for (i = 0; i < cg_text.length; i++) {
    cg_text[i].addEventListener("click", (event) => {
		if (options.defhidden != "click") return true;
		$ix = event.currentTarget.attributes['data-target'].value;
		a_text = document.querySelector('#'+$ix)
		a_text.classList.toggle('active')
		a_parent = event.currentTarget.parentElement;
		a_parent.classList.toggle('active');
	});
}
})
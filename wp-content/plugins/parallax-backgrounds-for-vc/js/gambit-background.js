document.addEventListener('DOMContentLoaded', function() {

	var elements = document.querySelectorAll('.gambit_background_row');

	Array.prototype.forEach.call(elements, function(el, i) {
		var row = document.gambitFindElementParentRow( el );

		row.style.position = 'relative';
		row.style.overflow = 'hidden';
		row.style.zIndex = '1';

		var div = document.createElement('div');

		var styles = getComputedStyle( el );
		div.classList.add('gambit_background_row_inner');
		div.style.backgroundImage = styles.backgroundImage;
		div.style.backgroundColor = styles.backgroundColor;
		div.style.backgroundRepeat = styles.backgroundRepeat;
		div.style.backgroundSize = styles.backgroundSize;
		div.style.backgroundPosition = styles.backgroundPosition;
		
		// Carry over the z-index of the placeholder div (this was set so we can layer different backgrounds properly)
		div.style.zIndex = el.style.zIndex;
	
		row.insertBefore(div, row.firstChild);
		
	});
	
});
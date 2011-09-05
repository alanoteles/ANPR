Ext.onReady(function() {
	if (typeof(MooTools) != "undefined" && typeof(MooTools.version) != "undefined" && parseFloat(MooTools.version) < 1.2 && (window.ie6 || window.ie7)) {
		Garbage.empty = function() {
			var gid = document.getElementById;
			
			Garbage.collect(window);
			Garbage.collect(document);
			Garbage.trash(Garbage.elements);
			
			document.getElementById = gid;
		}
	}
});
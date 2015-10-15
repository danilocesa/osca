var $categoryPicker = $("div#category-picker");
var $categoryModal = $("div#category-modal");
var $categoryList = $("div#category-list");

function initCategoryPicker(){
	$categoryModal.modal({
		backdrop: 'static',
		keyboard: false,
		show: false
	});

    $("ul.world > li > a").click(function(){
		$(this).children("span").toggleClass("glyphicon glyphicon-triangle-right").toggleClass("glyphicon glyphicon-triangle-bottom");
		$(this).siblings("ul.category").fadeToggle(100);
			// Collapse all subcategories when world is collapsed
		if ($(this).children("span").hasClass("glyphicon-triangle-right")){
		$(this).siblings("ul.category").find("li > a").children("span").attr("class", "glyphicon glyphicon-triangle-right");
		$(this).siblings("ul.category").find("ul.subcategory").fadeOut(100);
		}
		event.preventDefault();
	});
  
	$("ul.category > li > a").click(function(){
		$(this).children("span").toggleClass("glyphicon glyphicon-triangle-right").toggleClass("glyphicon glyphicon-triangle-bottom");
		$(this).siblings("ul.subcategory").fadeToggle(100);
		event.preventDefault();
	});
  
	$("a#show-category-picker").click(function(){
		$categoryList.html("");
		$categoryModal.modal('show');
		event.preventDefault();
	});
  
	$("a#hide-category-picker").click(function(){
		$categoryModal.modal('hide');
		updateListItems();
		event.preventDefault();
	});
  
	$($categoryList).on("click", "div.category-list-item > a", function(){
		var selected = $(this);
		$categoryPicker.find("input[type=checkbox]:checked").each(function(){
			if ($(this).attr("data-scid") == selected.attr("data-scid")) {
				selected.parent("div.category-list-item").remove();
				$(this).prop("checked", false).change();
			}
		});
		updateListItems();
		event.preventDefault();
	});
}

function selectSubcategories(subcategories){
	subcategories.forEach(function(value){
		$categoryPicker.find("input[type=checkbox][data-scid=\"" + value + "\"]").prop("checked", true);
	});
	
	updateListItems();
}

function updateListItems(){
    var html = "";          
    var prevCategory = null ;
    $categoryPicker.find("input[type=checkbox]:checked").each(function(index, value){
		// Separating worlds into new line
		if (index == 0){
			prevCategory = $(this).attr("data-wn");
		} else {
			if (prevCategory != $(this).attr("data-wn")){
				html += "<div class=\"divider\"></div>";
				prevCategory = $(this).attr("data-wn");
				}
		}
		html += "<div class=\"category-list-item\">";
		html += $(this).attr("data-wn");
		html += " > ";
		html += $(this).attr("data-cn");
		html += " > ";
		html += $(this).attr("data-scn");
		html += " <a href=\"#\" data-scid=\"" + $(this).attr("data-scid") + "\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
		html += "<input type=\"hidden\" name=\"subcategories[]\" value=\"" + $(this).attr("data-scid") + "\"\>";
		html += "</div> ";
    });
	
    $categoryList.html(html);
}
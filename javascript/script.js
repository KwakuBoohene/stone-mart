		function validate(){
			var title = document.forms["add_product"]["pname"];
			var category = document.forms["add_product"]["pcategory"];
			var brand = document.forms["add_product"]["pbrand"];
			var price = document.forms["add_product"]["pprice"];
			var regValidPrice = /([0-9]*[.])?[0-9]+/;
			if(!regValidPrice.test(price.value)){
				event.preventDefault();
				window.alert("Please enter a valid price");
				price.focus();
				return false;
			}else  if(!title.value){
				event.preventDefault();
				window.alert("Please enter a title");
				title.focus();
				return false;
			}else if(category.value == "0" ){
				event.preventDefault();
				window.alert("Please select a category");
				category.focus();
				return false;
			}else if(brand.value == "0"){
				event.preventDefault();
				window.alert("Please select a brand");
				brand.focus();
				return false;
			}else if(!price.value){
				event.preventDefault();
				window.alert("Please enter a price");
				price.focus();
			}else{
				return true;
			}
		}



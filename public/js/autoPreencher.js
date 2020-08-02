function autoPreencher(){
	var inputs = document.getElementsByName("lacre[]");
	var lacre = document.getElementById("lacreInicio");
	var de = document.getElementById("de");
	var ate = document.getElementById("ate");


	for (var i = 0; i < inputs.length; i++){
		inputs[i].id = i+1 ;
	}

	if(ate.value > inputs.length || de.value > inputs.length){
		alert("Quantidade De Lacres Muito Grande, Tente Novamente!");
	}
	else{

		for (var i = de.value-1; i < ate.value; i++){
				inputs[i].value = lacre.value++;
		}
  		
	}
	
}
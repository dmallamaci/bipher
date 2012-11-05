function valida(){
		if (document.fvalida.categoria.selectedIndex==0){
			alert("Falta elegir la categoria. \nComplete el formulario o use \nel boton Volver sin Guardar");
			return false;
		}
		else if (document.fvalida.provincia.selectedIndex==0){
			alert("Falta elegir la provincia. \nComplete el formulario o use \nel boton Volver sin Guardar");
			return false;
		}
		//Estan los datos
		return true;
}

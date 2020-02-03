var img = new Array("/images/drip_coffee.jpg","/images/coffee4.jpg","/images/coofee2.jpg");

var num = -1;
imgTimer();

function imgTimer() {

	if(num == 2) {
		num = 0;
	}else{
		num++;
	}
	document.topimage.src = img[num];

	setTimeout("imgTimer()", 4000);
	}

	// window.addEventListener('scroll',()=> {
	// 	var height = window.scrollY;
	// 	var target = document.getElementById('target');
	// 	if(height > 2070) {
	// 		target.classList.add('liner');
	// 	}else{
	// 		target.classList.remove('liner');
	// 	};
	// });


	function displayModalWindow() {
		const smallbar = document.getElementById('bar');
		smallbar.classList.toggle('modal');
		const ul = document.getElementById('ulmodal');
		ul.classList.toggle('ulmodal');
	}

	function formsubmit() {
		var error = 0;
		var regexp = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}$/;
		
		if(regexp.test(document.form.email.value) == false) {
			error ++;
		}
		if(document.form.email == "") {
			error++;
		}
		if(document.form.name.value == "") {
			error++;
		}
		if(document.form.text.value == ""){
			error++;
		}
		if(error > 0) {
			alert("正しく入力して下さい");
		}else{
			form.submit();
		}
	}
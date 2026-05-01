"use strict";
(function(){
	
	var forms = document.querySelectorAll('form');

	var isNotEmpty = function(value){
		return ((value !== null && !/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g.test(value)) 
      		&& value.trim().length >= 1);
	}

	var validation = {
		required: function(field){
			var type = field.type || field.nodeName.toLowerCase();
			if (!type) return false;
			if ((type === 'checkbox') || (type === 'radio')) {
				return (field.checked === true);
			}

			if ((type === 'select') || (type === 'select-one')){
				return (field.selectedIndex > 0);
			}

      		return ((field.value !== null && !/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g.test(field.value)) 
      		&& field.value.trim().length >= 1);

		},

		min: function(field, min){
			return (field.value >= min);
		},

		max: function(field, max){
			return (field.value <= max);
		},

		minLength: function(field, min){
			return (field.value.length >= min);
		},

		maxLength: function(field, max){
			return (field.value.length <= max);
		},

		alpha: function(field){
			return /^[a-zA-Z]+$/.test(field.value);
		},
		password: function(field){
			return /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/.test(field.value);
		},

		upperCase: function(field){
			return /^[A-Z]+$/.test(field.value);
		},

		upperCaseSpace: function(field){
			return /^[A-Z ]+$/.test(field.value);
		},

		lowerCase: function(field){
			return /^[a-z]+$/.test(field.value);
		},

		lowerCaseSpace: function(field){
			return /^[a-z ]+$/.test(field.value);
		},

		alphaSpace: function(field){
			return /^[a-zA-Z ]+$/.test(field.value);
		},

		numeric: function(field){
			return /^[0-9]+$/.test(field.value);
		},

		alphaNumeric: function(field){
			return /^[a-zA-Z0-9]+$/.test(field.value);
		},
		alphaNumericSpace: function(field){
			return /^[a-zA-Z0-9 ]+$/.test(field.value);
		},
		email: function(field){
			// return /^[\w!#$%&'*+/=?`{|}~^-]+(?:\.[\w!#$%&'*+/=?`{|}~^-]+)*@(?:[A-Z0-9-]+\.)+[A-Z]{2,6}$/.test(field.value);
			// return /^[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,6}$/.test(field.value);
			return /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/.test(field.value);
		},
		equals: function(field, field2){
			return field.value === field2.value;
		},
		notEquals: function(field, field2){
			return !(field.value === field2.value);
		},
		date: function(field){
			return new RegExp("^((19[0-9]{2}|2[0-9]{3}/(1[0-2]|0?[1-9])/3[01]|[12][0-9]|0?[1-9]))|((19[0-9]{2}|2[0-9]{3}-(1[0-2]|0?[1-9])-3[01]|[12][0-9]|0?[1-9]))$").test(field.value) && 
					validation.dateValid(field.value);
			// return new RegExp("^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$").test(field.value) && 
			// 		validation.dateValid(field.value);
			// return new RegExp("^(19|20)\d{2}([-/])(0[1-9]|1[0-2])\\2(0[1-9]|[12][0-9]|3[01])$").test(field.value) && 
			// 		validation.dateValid(field.value);
			// return new RegExp("^((?:19|20)\d{2}[-/](?:0[1-9]|1[0-2])[-/](?:0[1-9]|[12]\d|3[01]))|((?:0[1-9]|[12]\d|3[01])[-/](?:0[1-9]|1[0-2])[-/](?:19|20)\d{2})$").test(field.value) && 
			// 		validation.dateValid(field.value);
			// return new RegExp("^((?:19|20)\d{2}[-/](?:0[1-9]|1[0-2])[-/](?:0[1-9]|[12]\d|3[01]))|((?:0[1-9]|[12]\d|3[01])[-/](?:0[1-9]|1[0-2])[-/](?:19|20)\d{2})$").test(field.value);

		},
		dateValid: function(field){
			var date = (field.includes('-')) ? field.split('-') : field.split('/'),
						val = false,
						daysinmonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
			if(date[0].length > 4) return false;

			if (parseInt(date[1]) == 2 && date[0] % 4 == 0 && (date[0] % 100 != 0 || date[0] % 400 == 0)) {
				if (parseInt(date[2]) >= 1 && parseInt(date[2]) <= 29) val = true;
			} else {
				if(parseInt(date[2]) >= 1 && parseInt(date[2]) <= daysinmonth[parseInt(date[1]) - 1]) val = true;
			}
			return val;
		},
		cedula: function(field){
			return new RegExp("^([VE])(?!0)[0-9]{7,8}$", 'i').test(field.value);
		},
		phone: function(field){
			// return new RegExp("^(0(426|416|412|212|424|414)-[0-9]{7})|(^0(426|416|412|212|424|414)[0-9]{7}$)$").test(field.value);
			return new RegExp("^0(4(12|14|16|24|26)|212)[0-9]{7}$").test(field.value);
		},
		time: function(field){
			return new RegExp("^(2[0-3]|[01]?[0-9]):([0-5]?[0-9])$").test(field.value);
		},
		times: function(field, field2){
			var tiempo = (field.value.includes(':')) ? field.value.split(':') : null,
				tiempo2 = (field2.value.includes(':')) ? field2.value.split(':') : null,
				date = new Date(),
				date2 = new Date();
			if (!tiempo) return false;
			if (!tiempo2) return false;
			
			date.setHours(tiempo[0], tiempo[1]);
			date2.setHours(tiempo2[0], tiempo2[1]);
			return (date < date2);
		},
		dateMinor: function(field, field2){
			var fecha = (validation.required(field) && field.value.includes('-')) ? field.value.split('-') : '',
				fecha2 = (validation.required(field2) && field2.value.includes('-')) ? field2.value.split('-') : '',
				date, date2;

				if (fecha.length >= 1) {
					date = new Date(Date.UTC(fecha[0], fecha[1]-1, fecha[2], 0, 0, 0));
					date.toLocaleDateString("es-VE", { timeZone: "UTC" });
				}
				if (fecha2.length >= 1) {
					date2 = new Date(Date.UTC(fecha2[0], fecha2[1]-1, fecha2[2], 0, 0, 0));
					date2.toLocaleDateString("es-VE", { timeZone: "UTC" });
				}

				return (date < date2);
		},
		dateHigh: function(field, field2){
			var fecha = (validation.required(field) && field.value.includes('-')) ? field.value.split('-') : '',
				fecha2 = (validation.required(field2) && field2.value.includes('-')) ? field2.value.split('-') : '',
				date, date2;

				if (fecha.length >= 1) {
					date = new Date(Date.UTC(fecha[0], fecha[1]-1, fecha[2], 0, 0, 0));
					date.toLocaleDateString("es-VE", { timeZone: "UTC" });
				}
				if (fecha2.length >= 1) {
					date2 = new Date(Date.UTC(fecha2[0], fecha2[1]-1, fecha2[2], 0, 0, 0));
					date2.toLocaleDateString("es-VE", { timeZone: "UTC" });
				}

				return (date > date2);
		},
		dateEquals: function(field, field2){
			var fecha = (validation.required(field) && field.value.includes('-')) ? field.value.split('-') : '',
				fecha2 = (validation.required(field2) && field2.value.includes('-')) ? field2.value.split('-') : '',
				date, date2;

				if (fecha.length >= 1) {
					date = new Date(Date.UTC(fecha[0], fecha[1]-1, fecha[2], 0, 0, 0));
					date.toLocaleDateString("es-VE", { timeZone: "UTC" });
				}
				if (fecha2.length >= 1) {
					date2 = new Date(Date.UTC(fecha2[0], fecha2[1]-1, fecha2[2], 0, 0, 0));
					date2.toLocaleDateString("es-VE", { timeZone: "UTC" });
				}

				return (date == date2);
		},
		dateNotEquals: function(field, field2){
			var fecha = (validation.required(field) && field.value.includes('-')) ? field.value.split('-') : '',
				fecha2 = (validation.required(field2) && field2.value.includes('-')) ? field2.value.split('-') : '',
				date, date2;

				if (fecha.length >= 1) {
					date = new Date(Date.UTC(fecha[0], fecha[1]-1, fecha[2], 0, 0, 0));
					date.toLocaleDateString("es-VE", { timeZone: "UTC" });
				}
				if (fecha2.length >= 1) {
					date2 = new Date(Date.UTC(fecha2[0], fecha2[1]-1, fecha2[2], 0, 0, 0));
					date2.toLocaleDateString("es-VE", { timeZone: "UTC" });
				}
				return (date != date2);
		}
	}

	var validate = {
		input: function(field){
			var form = field.form,
				rules,
				error = [];
			// console.log(field.hasAttribute('readonly'));
			if (!form.classList.contains('validate')) return true;
			if (!field.dataset.hasOwnProperty('rules') || field.disabled) return true;
			if (field.hasAttribute('readonly')) return true;
			if (!field.dataset.rules.length) return true;
			// if (field.dataset.rules.length) {
			rules = field.dataset.rules.split('|');
			// if (!rules.includes('required') && rules.length < 1) return true;
			rules.forEach(function(index){
				var param = index.split(':'),
					name = (field.labels && field.labels.length >= 1) ? field.labels[0].textContent.toLowerCase() : field.name.toLowerCase(),
					element = null,
					error2 = {};
				if (validation[param[0]]){
					switch (param[0]) {
						case 'required':
							if (!validation.required(field)){
								error.push("Este campo es obligatorio");
							}
							break;
						case 'email':
							// console.log(validation.email(field));
							if (rules.includes('required')){
								if (!validation.email(field)){
									error.push("Ingrese un correo valido");
								}
							}
							break;
						case 'password':
							// console.log(validation.email(field));
							if (rules.includes('required')){
								if (!validation.password(field)){
									error.push("La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula, al menos una mayúscula. No puede tener caracteres especiales.");
								}
							}
							break;
						case 'equals':
							// console.log(validation.email(field));
							if (rules.includes('required')){
								// console.log(param);
								if(!isNotEmpty(param[1])) throw "parámentro faltante";
								element = document.getElementById(param[1]);
								console.log(validation.equals(field, element));
								if (!validation.equals(field, element)){
									error.push("Ambos campos deben coincidir");
								}
							}
							break;
						case 'upperCase':
							if (rules.includes('required')){
								if(!validation.upper(field)){
									error.push("Este campo solo debe contener letras mayúsculas");
								}
							}
							break;
						case 'upperCaseSpace':
							if (rules.includes('required')){
								if(!validation.upperCaseSpace(field)){
									error.push("Este campo solo debe contener letras mayúsculas y espacio");
								}
							}
							break;
						case 'lowerCase':
							if (rules.includes('required')){
								if(!validation.lower(field)){
									error.push("Este campo solo debe contener letras minúsculas");
								}
							}
							break;
						case 'lowerCaseSpace':
							if (rules.includes('required')){
								if(!validation.lowerCaseSpace(field)){
									error.push("Este campo solo debe contener letras minúsculas y espacio");
								}
							}
							break;
						case 'alpha':
							if (rules.includes('required')){
								if(!validation.alpha(field)){
									error.push("Este campo debe contener letras");
								}
							}
							
							break;
						case 'alphaSpace':
							if (rules.includes('required')){
								if(!validation.alphaSpace(field)){
									error.push("Este campo debe contener letras o espacios");
								}
							}
							
							break;
						case 'min':
							if (rules.includes('required')){
								if(!validation.min(field, param[1])){
									error.push("Este campo debe ser mayor que "+param[1]);
								}
							}
							
							break;
						case 'max':
							if (rules.includes('required')){
								if(!validation.max(field, param[1])){
									error.push("Este campo debe ser mayor que "+param[1]);
								}
							}
							
							break;
						case 'minLength':
							if (rules.includes('required')){
								if(!validation.minLength(field, param[1])){
									error.push("Este campo debe contener más de "+param[1]+" caracteres");
								}
							}
							
							break;
						case 'maxLength':
							if (rules.includes('required')){
								if(!validation.maxLength(field, param[1])){
									error.push("Este campo no debe contener más de "+param[1]+" caracteres");
								}
							}
							
							break;
						case 'numeric':
							if (rules.includes('required')){
								if(!validation.numeric(field)){
									error.push("Este campo debe contener solo números");
								}
							}
							
							break;
						case 'alphaNumeric':
							if (rules.includes('required')){
								if(!validation.alphaNumeric(field)){
									error.push("Este campo debe contener solo números y letras");
								}
							}
							
							break;
						case 'alphaNumericSpace':
							if (rules.includes('required')){
								// console.log(validation.alphaNumericSpace(field));
								if(!validation.alphaNumericSpace(field)){
									error.push("Este campo debe contener solo números, letras y espacio");
								}
							}
							
							break;
						case 'date':
							if (rules.includes('required')){
								if(!validation.date(field)){
									error.push("Este campo es una fecha inválida");
								}
							}
							
							break;
						case 'cedula':
							if (rules.includes('required')){
								console.log(validation.cedula(field));
								if(!validation.cedula(field)){
									error.push("Este campo debe contener el siguiente formato V00000000");
								}
							}
							
							break;
						case 'phone':
							if (rules.includes('required')){
								if(!validation.phone(field)){
									error.push("Este campo debe contener el número de teléfono válido");
								}
							}
							break;
						case 'time':
							if (rules.includes('required')){
								// if (field.dataset.times){
								// 	element = document.getElementById(field.dataset.times);
								// 	if (!validation.times(element, field)){
								// 		error2[element.name] = ["La primera hora debe ser menor que el segundo"];
								// 		showMessages(element, error2);
								// 	} else {
								// 		removeMessages(element);
								// 	}
								// 	error2 = {};
								// }
								// if(!validation.time(field)){
								// 	error.push("Este campo debe contener un tiempo válido");
								// }
							}
							break;
						case 'times':
							if (rules.includes('required')){
								if(!isNotEmpty(param[1])) throw "parámentro faltante";
								element = document.getElementById(param[1]);
								if ((!validation.required(field) && !validation.time(field)) && !validate.input(element)){
									error2[element.name] = ["Se debe rellenar ambos campos y debe ser horas válidas"];
									showMessages(field, error2);
								}else if(!validation.required(field) && !validation.time(field)) {
									error2[element.name] = ["Debe rellenar este campo y debe se una hora válida"];
									showMessages(field, error2);
								}else if(!validate.input(element)) {
									error2[element.name] = ["Debe rellenar este campo y debe se una hora válida"];
									showMessages(element, error2);
								} else {
									if (!validation.times(field, element)){
										error.push("La primera hora debe ser menor que la segunda");
									}
								}
							}

							break;
						case 'dateHigh':
							if (rules.includes('required')){
								if(!isNotEmpty(param[1])) throw "parámentro faltante";
								element = document.querySelector('#'+param[1]);
								if (!validation.required(element)){
									error2[element.name] = ["Se debe rellenar ambos campos"];
									showMessages(field, error2);
								}
								if(!validation.required(field)){
									// error.push("Se debe rellenar ambos campos");
								}
								if(!validation.dateNotEquals(field,element)){
									// error.push("Ambas fechas no pueden ser idéntico");
								}
								if (!validation.dateHigh(field, element)){
									error.push("Esta fecha no puede ser inferior");
								} else {
									removeMessages(element);
								}
							}
							error2 = {};
							break;
						case 'dateMinor':
							if (rules.includes('required')){
								if(!isNotEmpty(param[1])) throw "parámentro faltante";
								element = document.querySelector('#'+param[1]);
								if (!validation.required(element)){
									error2[element.name] = ["Se debe rellenar ambos campos"];
									showMessages(field, error2);
								}
								if(!validation.required(field)){
									// error.push("Se debe rellenar ambos campos");
								}
								if(!validation.dateNotEquals(field,element)){
									// error.push("Ambas fechas no pueden ser idéntico");
								}
								if (!validation.dateMinor(field, element)){
									error.push("Esta fecha no puede ser superior");
								} else {
									removeMessages(element);
								}
							}
							error2 = {};
							break;
						case 'dateNotEquals':
							if (rules.includes('required')){
								if(!isNotEmpty(param[1])) throw "parámentro faltante";
								element = document.querySelector('#'+param[1]);
								if (!validation.required(element)){
									error2[element.name] = ["Se debe rellenar ambos campos"];
									showMessages(field, error2);
								}
								if(!validation.required(field)){
									// error.push("Se debe rellenar ambos campos");
								}

								if(!validation.dateNotEquals(field,element)){
									error.push("Ambas fechas no pueden ser idéntico");
								} else {
									removeMessages(element);
								}
								
							}
							error2 = {};
							break;
						case 'datesEquals':
							if (rules.includes('required')){
								if(!isNotEmpty(param[1])) throw "parámentro faltante";
								element = document.querySelector('#'+param[1]);
								if (!validation.required(element)){
									error2[element.name] = ["Se debe rellenar ambos campos"];
									showMessages(field, error2);
								}
								if(!validation.required(field)){
									// error.push("Se debe rellenar ambos campos");
								}
								if (!validation.dateEquals(field, element)){
									error.push("Esta fecha debe ser identico");
								} else {
									removeMessages(element);
								}
							}

							// error2 = {};
							break;
							
					}
				} else {
					throw "Método no definido " + param[0];
				}
			});
			if (error.length){
				errors[field.name] = error;
				return false;
			} else {
				return true;
			}
		},
		form: function(field){
			var elements = this.elements,
				element;
			// field.preventDefault();
			// field.stopImmediatePropagation();
			if (this.classList.contains('validate')){
				for (var i = 0; i < elements.length; i++) {
					if (/^(submit|reset)$/.test(elements[i].type || elements[i].nodeName.toLowerCase())) {
						continue;
					} else {
						if (!validate.input(elements[i])){
							showMessages(elements[i], errors);
							if (!element){
								element = elements[i];
							}
						} else {
							removeMessages(elements[i]);
						}
					}
				}
				if (element){
					field.preventDefault();
					field.stopImmediatePropagation();
					element.focus();
				}
				// if (this.dataset.ajax){
				// 	field.preventDefault();
				// 	field.stopImmediatePropagation();
				// }
			}
		}
	}

	var reset = function(field){
		var elements = this.elements;
		this.reset();
		for (var i = 0; i < elements.length; i++) {
			if(!/^(submit|reset)$/.test(elements[i].type || 
			elements[i].nodeName.toLowerCase())){
				removeMessages(elements[i]);
				elements[i].parentElement.classList.remove('invalid-feedback');
				elements[i].classList.remove('is-valid');
				// console.log(elements[i]);
			}
		}
	}

	var showMessages = function(field, data){
		if (!data.hasOwnProperty(field.name)) return;
		var message = field.parentElement.querySelector('div.invalid-feedback');
		// console.log(field.name);
		if (!message){
			message = document.createElement('div');
			message.className = 'invalid-feedback';
			field.parentElement.insertBefore(message, field.nextSibling);
		}
		message.innerHTML = data[field.name].join(', ').replace("-", " ");
		field.setCustomValidity(data[field.name].join(', ').replace("-", " "));
		field.classList.remove('is-valid');
		field.classList.add('is-invalid');
		// console.log(field.classList);
		message.style.display = 'block';
		message.style.visibility = 'visible';
	}

	var removeMessages = function(field){
		var message = field.parentElement.querySelector('div.invalid-feedback');
		if (!message) return;
		message.innerHTML = '';
		field.setCustomValidity('');
		field.classList.remove('is-invalid');
		field.classList.add('is-valid');
		// console.log(field.classList);
		message.style.display = 'none';
		message.style.visibility = 'hidden';
		errors = {};
	}

	for (var i = 0; i < forms.length; i++) {
		var elements = forms[i].elements;
		forms[i].setAttribute('novalidate', true);
		forms[i].addEventListener('submit', validate.form);
		forms[i].addEventListener('reset', reset);
		for (var j = 0; j < elements.length; j++) {
			if(!/^(submit|reset)$/.test(elements[j].type || 
				elements[j].nodeName.toLowerCase())){
				elements[j].addEventListener('input', function(evt){
					if (!validate.input(evt.target)){
						showMessages(evt.target, errors);
					} else {
						removeMessages(evt.target);
					}
				});
			elements[j].addEventListener('focus', function(evt){
				// errors = {};
			});
			elements[j].addEventListener('blur', function(evt){
					if (!validate.input(evt.target)){
						showMessages(evt.target, errors);
					} else {
						removeMessages(evt.target);
					}
				});
			}
		}
	}

	// btnsubmit.addEventListener('click', validate.form);

	var errors = {};

}());

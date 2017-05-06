$( document ).ready(function() {
    $("#btn").click( // клик по кнопке Отправить
		function(){
            if (validateForm()) {  // если прошла валидация, то отправялем аякс запрос
                sendAjaxForm('ajax_form', 'actionForm.php');
                return false;
            }
		}
	);
});
 
function sendAjaxForm(ajax_form, url) {
    jQuery.ajax({
        url:     url, //url страницы
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: jQuery("#"+ajax_form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
            result = jQuery.parseJSON(response);
            if (result == 'Yes') { //Если пришел yes, то данные успешно добавлены, и выводим сообщение об этом, очищаем форму и готовы к новому запросу
                document.getElementById("result").innerHTML = "Данные успешно занесены в базу";
                clearForm();
            }
            else {  //иначе выводим сообщение об возникшей ошибке
                document.getElementById("result").innerHTML = result;
            }
    	},
    	error: function(response) { // Данные не отправлены
    		document.getElementById("result").innerHTML = "Ошибка. Данные не отправленны.";
    	}
 	});
};

function  clearForm() { //очистка формы, задаем пустые значения полям
    $("#name").val("");
    $("#phone").val("");
    $("#email").val("");
    $("#question").val("");
    $("#budget").val("");
    $("#product").val("0");
};

function validateForm () { // проверка валидации формы, возвращает сообщение об ошибке и false если какое-то поле не прошло проверку
    var name = document.getElementById('name');
    if (name.value.trim() == '') {
        alert('Проверьте имя, оно не должно быть пустое');
        $('#name').focus();
        return false;
    }
    var phone = document.getElementById('phone');  //Длина телефона меньше 6 символов
    if ((phone.value.trim() != '') && phone.value.trim().length < 6) {
        alert("Проверьте номер телефона");
        $('#phone').focus();
        return false;
    }
    var email = document.getElementById('email'); //Правильного вида емейл
    var email_regexp = /[0-9a-zа-я_A-ZА-Я]+@[0-9a-zа-я_A-ZА-Я^.]+\.[a-zа-яА-ЯA-Z]{2,4}/i;
    if ((email.value.trim() != '') && (!email_regexp.test(email.value))) {
        alert('Проверьте email');
        $('#email').focus();
        return false;
    }
    var product = document.getElementById('product');
    if (product.value == "0") {
        alert('Проверьте список продуктов');
        $('#product').focus();
        return false;
    }
    return true;
}

$(document).ready(function() {  // в поле Бюджет можно вводить только цифры
    $("#budget").keydown(function(event) {
        // Разрешаем: backspace, delete, tab и escape
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27) {
            // Ничего не делаем
            return;
        }
        else {
            // Обеждаемся, что это цифра, и останавливаем событие keypress
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault();
            }
        }
    });
});

$(document).ready(function() {  // в поле телефон, можно вводить цифры
    $("#phone").keydown(function(event) {
        // Разрешаем: backspace, delete, tab, escape, скобочки, пробел и плюс
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 107 || event.keyCode == 40 || event.keyCode == 41 || event.keyCode == 32) {
            // Ничего не делаем
            return;
        }
        else {
            // Обеждаемся, что это цифра, и что длина не более 15 символов и останавливаем событие keypress
            var name = document.getElementById('phone');
            if (((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) || (name.value.trim().length > 15)) {
                event.preventDefault();
            }
        }
    });
});

$(document).ready(function() { // проверка телефона при потере фокуса
    $("#phone").change(function () {
        var name = document.getElementById('phone');
        if (name.value.trim().length < 6) {
            alert("Проверьте номер телефона");
            $('#phone').focus();
        }
    })
});




 



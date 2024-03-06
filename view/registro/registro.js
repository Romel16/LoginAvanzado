function init() {
     /* TODO: Escucha el evento submit del formulario */
     $("#mnt_form").on("submit", function (e) {
        /* TODO: Evita que el formulario se envíe automáticamente */
        e.preventDefault();

        /* TODO: Validar el formulario antes de enviarlo */
        if(isFormValid()){
            /* TODO: Si es válido, enviar datos */
            register(e);
        }else{
            /* TODO: si no es válido, muestra mensajes de error */
            displayValidationMessages();
        }
    });
}

function isFormValid(){
    /* TODO: Usa Validator.js para validar cada campo del formulario */
    return validateEmail() && validateText("usuarioNombreApellido") && validatePassword() && validatePasswordMatch();
}

function validateEmail(){
    var email = $("#usuarioCorreo").val();
    var isValid = validator.isEmail(email);

    /* TODO:Muestra el mensaje de error si la validación no es exitosa */
    displayErrorMessage("#usuarioCorreo",isValid,"Ingrese Correo Electrónico");

    return isValid;
}

function validateText(fieldId){
    var value = $("#" + fieldId).val();
    var isValid = validator.isLength(value,{min:1});

    /* TODO:Muestra el mensaje de error si la validación no es exitosa */
    displayErrorMessage("#" + fieldId ,isValid,"Este campo es obligatorio.");

    return isValid;
}

function validatePassword(){
    var password = $("#usuarioPassword").val();
    var isValid = validator.isLength(password,{min: 8});

    /* TODO:Muestra el mensaje de error si la validación no es exitosa */
    displayErrorMessage("#usuarioPassword" ,isValid,"La contraseña debe tener al menos 8 caracteres.");

    return isValid;
}

function validatePasswordMatch(){
    var password = $("#usuarioPassword").val();
    var confirmPassword = $("#userpassword").val();
    var isValid = validator.equals(password,confirmPassword);

    /* TODO:Muestra el mensaje de error si la validación no es exitosa */
    displayErrorMessage("#userpassword" ,isValid,"Las contraseñas no coinciden.");

    return isValid;
}

function displayErrorMessage(fieldSelector, isValid, message){
    /* TODO: Busca el elemento de mensaje de error y actualiza su contenido */
    var errorField = $(fieldSelector).next(".validation-error");
    errorField.text(isValid ? "" : message);
    errorField.toggleClass("text-danger", !isValid);
}

function displayValidationMessages(){
    /* TODO: Muestra mensajes de error cerca de los campos del formulario */
    validateEmail();
    validateText("usuarioNombreApellido");
    validatePassword();
    validatePasswordMatch();
}

function register() {
    var formData = new FormData($("#mnt_form")[0]);
    $.ajax({
        url: "../../controllers/usuarioControllers.php?op=register",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
                console.log(datos);
            }
    });
}

init();
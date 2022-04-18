function cep(inputClass, outputClass) {
    $(function () {
// SEARCH ZIPCODE
        $(inputClass).blur(function () {

            function emptyForm() {
                $(outputClass).val("");
            }

            var zip_code = $(this).val().replace(/\D/g, '');
            var validate_zip_code = /^[0-9]{8}$/;

            if (zip_code != "" && validate_zip_code.test(zip_code)) {

                $(outputClass).val("");

                $.getJSON("https://viacep.com.br/ws/" + zip_code + "/json/?callback=?", function (data) {

                    if (!("erro" in data)) {
                        $(outputClass).val(data.logradouro);
                        $(".district").val(data.bairro);
                        $(".state").val(data.uf);
                    } else {
                        emptyForm();
                        Toastify({
                            text: "Ops! O CEP não foi encontrado.",
                            duration: 3000,
                            gravity: "bottom",
                            position: "right",
                            style: {
                                background: 'linear-gradient(242deg, rgba(249,2,2,1) 0%, rgba(217,0,0,1) 48%)',
                            },
                        }).showToast();
                    }
                });
            } else {
                emptyForm();
                Toastify({
                    text: "Ops! Formato de CEP inválido.",
                    duration: 3000,
                    gravity: "bottom",
                    position: "right",
                    style: {
                        background: 'linear-gradient(242deg, rgba(249,2,2,1) 0%, rgba(217,0,0,1) 48%)',
                    },
                }).showToast();
            }
        });
    });
}

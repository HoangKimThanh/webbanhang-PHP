
function Validator(options) {
    // Hàm lấy parentElement của inputElement
    function getParentElement(element, selector) {
        while (element.parentElement) {
            if (element.parentElement.matches(selector)) {
                return element.parentElement;
            }
            else {
                element = element.parentElement;
            }
        }
    }

    var selectorRules = {};

    // Lấy element của form cần validate
    var formElement = document.querySelector(options.form);

    if (formElement) {
        // Xử lý sự kiện submit
        formElement.onsubmit = function (e) {
            e.preventDefault();

            var isFormValid = true;
            // Kiểm tra tính hợp lệ của form
            options.rules.forEach(function (rule) {
                var inputElement = formElement.querySelector(rule.selector);

                var errorElement = getParentElement(inputElement, options.formGroupSelector).querySelector(options.errorElement);

                validate(inputElement, errorElement, rule);

                if (isFormValid) {
                    isFormValid = validate(inputElement, errorElement, rule);
                }
            })

            // Kiểm tra có hàm submit trong object Validator không
            if (isFormValid) {
                if (typeof options.onSubmit === 'function') {
                    var enableInputs = formElement.querySelectorAll('[name]:not([disabled])');

                    var formValues = Array.from(enableInputs).reduce(function (values, input) {
                        switch (input.type) {
                            case 'radio':
                                if (input.checked) {
                                    values[input.name] = input.value;
                                }
                                break;
                            case 'checkbox':
                                if (input.checked) {
                                    if (Array.isArray(values[input.name])) {
                                        values[input.name].push(input.value);
                                    } else {
                                        values[input.name] = [input.value];
                                    }
                                } else {
                                    return values;
                                }
                                break;
                            case 'file':
                                values[input.name] = input.files;
                                break;
                            default:
                                values[input.name] = input.value;
                        }
                        return values;
                    }, {})

                    options.onSubmit(formValues);
                } else {
                    submitForm(formElement);
                }
            }
        }

        // Lặp qua mỗi rule và xử lý
        options.rules.forEach(function (rule) {

            // Lưu lại các rules của các input
            if (Array.isArray(selectorRules[rule.selector])) {
                selectorRules[rule.selector].push(rule.test);
            } else {
                selectorRules[rule.selector] = [rule.test];
            }

            // var inputElements = formElement.querySelectorAll(rule.selector);

            var inputElement = formElement.querySelector(rule.selector);

            // Array.from(inputElements).forEach(function (inputElement) {
            //     // Xử lý blur ra ngoài
            //     inputElement.onblur = function () {
            //         validate(inputElement, errorElement, rule)
            //     }

            //     // Xử lý trường hợp đang nhập
            //     inputElement.oninput = function () {
            //         getParentElement(inputElement, options.formGroupSelector).classList.remove('invalid');
            //         errorElement.innerText = '';
            //     }
            //     var errorElement = getParentElement(inputElement, options.formGroupSelector).querySelector(options.errorElement);
            // })

            // Xử lý blur ra ngoài
            inputElement.onblur = function () {
                validate(inputElement, errorElement, rule)
            }

            // Xử lý trường hợp đang nhập
            inputElement.oninput = function () {
                getParentElement(inputElement, options.formGroupSelector).classList.remove('invalid');
                errorElement.innerText = '';
            }
            var errorElement = getParentElement(inputElement, options.formGroupSelector).querySelector(options.errorElement);

        })

        // Hàm thực hiện validate
        function validate(inputElement, errorElement, rule) {
            // Xử lý trường hợp blur khỏi input

            // Lấy ra các rules của selector
            var rules = selectorRules[rule.selector];

            var errorMessage;

            // Lặp qua từng rule & kiểm tra 
            // Nếu có lỗi thì dừng việc kiểm tra
            for (let i = 0; i < rules.length; i++) {
                switch (inputElement.type) {
                    case 'radio':
                    case 'checkbox':
                        errorMessage = rules[i](
                            formElement.querySelector(rule.selector + ':checked')
                        )
                        break;
                    default:
                        errorMessage = rules[i](inputElement.value);
                }
                if (errorMessage) {
                    break;
                }
            }
            if (errorMessage) {
                getParentElement(inputElement, options.formGroupSelector).classList.add('invalid');
                errorElement.innerText = errorMessage;
                return false;
            } else {
                getParentElement(inputElement, options.formGroupSelector).classList.remove('invalid');
                errorElement.innerText = '';
                return true;
            }
        }
    }
}

function submitForm(form) {
    const submitFormFunction = Object.getPrototypeOf(form).submit;
    submitFormFunction.call(form);
}

Validator.isRequired = function (selector, message) {
    return {
        selector,
        test: function (value) {
            if (value === null) {
                return value ? undefined : message || 'Vui lòng nhập trường này';
            }
            return value.toString().trim() ? undefined : message || 'Vui lòng nhập trường này';
        }
    }
}

Validator.isFullName = function (selector, message) {
    return {
        selector,
        test: function (value) {
            var regex = /^[A-EG-IK-VXYÀÁẢÃẠĂẮẰẲẴẶÂẤẦẨẪẬẸẺẼÈÉÊỀẾỂỄỆÌÍỈỊĨÒÓỌỎÕÔỐỒỔỖỘƠỚỜỞỠỢÙÚŨỤỦĐƯỨỪỬỮỰỲỴÝỶỸ][a-eg-ik-vxyàáảãạăắằẳẵặâấầẩẫậẹẻẽèéêềếểễệìíỉịĩòóọỏõôốồổỗộơớờởỡợùúũụủđưứừửữựỳỵýỷỹ]{0,6}(?: [A-EG-IK-VXYÀÁẢÃẠĂẮẰẲẴẶÂẤẦẨẪẬẸẺẼÈÉÊỀẾỂỄỆÌÍỈỊĨÒÓỌỎÕÔỐỒỔỖỘƠỚỜỞỠỢÙÚŨỤỦĐƯỨỪỬỮỰỲỴÝỶỸ][a-eg-ik-vxyàáảãạăắằẳẵặâấầẩẫậẹẻẽèéêềếểễệìíỉịĩòóọỏõôốồổỗộơớờởỡợùúũụủđưứừửữựỳỵýỷỹ]{0,6}){0,8}$/;
            return regex.test(value) ? undefined : message || 'Vui lòng nhập trường này';
        }
    }
}

Validator.isEmail = function (selector, message) {
    return {
        selector,
        test: function (value) {
            var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            return regex.test(value) ? undefined : message || 'Vui lòng nhập trường này';
        }
    }
}

Validator.isPhone = function (selector, message) {
    return {
        selector,
        test: function (value) {
            var regex = /^(((\+|)84)|0)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/;
            return regex.test(value) ? undefined : message || 'Vui lòng nhập trường này';
        }
    }
}

Validator.minLength = function (selector, min, message) {
    return {
        selector,
        test: function (value) {
            return value.length >= min ? undefined : `Mật khẩu phải tối thiểu ${min} ký tự`;
        }
    }
}

Validator.isStrong = function (selector, message) {
    return {
        selector,
        test: function (value) {
            var regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/;
            return regex.test(value) ? undefined : message || 'Vui lòng nhập trường này';
        }
    }
}

Validator.isConfirmed = function (selector, getConfirmValue, message) {
    return {
        selector,
        test: function (value) {
            return value === getConfirmValue() ? undefined : message || 'Gia tri nhap vao khong chinh xac';
        }
    }
}
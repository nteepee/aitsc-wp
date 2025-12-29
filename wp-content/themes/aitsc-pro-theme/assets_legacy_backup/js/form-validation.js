/**
 * Enhanced Form Validation System
 * Field-specific validation with detailed error messages and ARIA support
 * Real-time validation, progressive enhancement, and comprehensive accessibility
 */

(function() {
    'use strict';

    /**
     * Enhanced Form Validator Class
     */
    class EnhancedFormValidator {
        constructor(form) {
            this.form = form;
            this.fields = new Map();
            this.validationRules = new Map();
            this.errorMessages = new Map();
            this.debounceTimers = new Map();
            this.isValidating = false;
            this.submissionAttempts = 0;

            this.init();
        }

        /**
         * Initialize enhanced validation system
         */
        init() {
            this.setupFieldValidation();
            this.setupRealtimeValidation();
            this.setupAccessibilityEnhancements();
            this.setupProgressiveEnhancement();
            this.setupCustomValidation();
        }

        /**
         * Setup field validation with enhanced rules
         */
        setupFieldValidation() {
            const fields = this.form.querySelectorAll('input, textarea, select');

            fields.forEach(field => {
                this.initializeField(field);
                this.setupFieldRules(field);
                this.setupFieldEvents(field);
            });
        }

        /**
         * Initialize individual field
         */
        initializeField(field) {
            const fieldName = this.getFieldName(field);
            const fieldType = this.getFieldType(field);

            // Store field information
            this.fields.set(field, {
                name: fieldName,
                type: fieldType,
                element: field,
                isValid: null,
                lastValidated: null,
                validationCount: 0
            });

            // Add ARIA attributes
            this.enhanceFieldAccessibility(field);
        }

        /**
         * Get field name with fallbacks
         */
        getFieldName(field) {
            return field.name ||
                   field.id ||
                   field.getAttribute('data-name') ||
                   field.getAttribute('aria-label') ||
                   this.generateFieldName(field);
        }

        /**
         * Get enhanced field type
         */
        getFieldType(field) {
            const type = field.type || field.tagName.toLowerCase();

            // Enhanced type detection
            if (field.hasAttribute('data-type')) {
                return field.getAttribute('data-type');
            }

            if (field.classList.contains('email')) return 'email';
            if (field.classList.contains('phone') || field.classList.contains('telephone')) return 'phone';
            if (field.classList.contains('url') || field.classList.contains('website')) return 'url';
            if (field.classList.contains('zipcode') || field.classList.contains('postal-code')) return 'zipcode';
            if (field.classList.contains('creditcard') || field.classList.contains('card-number')) return 'creditcard';
            if (field.classList.contains('cvv') || field.classList.contains('cvc')) return 'cvv';
            if (field.classList.contains('expiry') || field.classList.contains('expiration')) return 'expiry';

            return type;
        }

        /**
         * Generate field name from context
         */
        generateFieldName(field) {
            const label = field.closest('label') ||
                          document.querySelector(`label[for="${field.id}"]`) ||
                          (() => {
                              const formGroup = field.closest('.form-group');
                              return formGroup ? formGroup.querySelector('label, .field-label') : null;
                          })();

            if (label) {
                return label.textContent.trim().replace(/\*+$/, '').trim();
            }

            const placeholder = field.getAttribute('placeholder');
            if (placeholder) {
                return placeholder.trim();
            }

            return `${field.tagName.toLowerCase()}_${Array.from(document.querySelectorAll(field.tagName)).indexOf(field)}`;
        }

        /**
         * Setup enhanced validation rules
         */
        setupFieldRules(field) {
            const fieldInfo = this.fields.get(field);
            const rules = this.getFieldValidationRules(field);

            this.validationRules.set(field, rules);
        }

        /**
         * Get validation rules for field type
         */
        getFieldValidationRules(field) {
            const fieldInfo = this.fields.get(field);
            const fieldType = fieldInfo.type;
            const fieldName = fieldInfo.name.toLowerCase();

            const rules = {
                required: field.hasAttribute('required'),
                minLength: parseInt(field.getAttribute('minlength')) || 0,
                maxLength: parseInt(field.getAttribute('maxlength')) || Infinity,
                pattern: field.getAttribute('pattern'),
                custom: [],
                messages: this.getFieldSpecificMessages(fieldType, fieldName)
            };

            // Type-specific rules
            switch (fieldType) {
                case 'email':
                    rules.pattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                    rules.validators = [this.validateEmail.bind(this)];
                    break;

                case 'phone':
                case 'tel':
                    rules.pattern = /^[\d\s\-\+\(\)]+$/;
                    rules.validators = [this.validatePhone.bind(this)];
                    break;

                case 'url':
                    rules.validators = [this.validateURL.bind(this)];
                    break;

                case 'zipcode':
                    rules.validators = [this.validateZipCode.bind(this)];
                    break;

                case 'creditcard':
                    rules.validators = [this.validateCreditCard.bind(this)];
                    break;

                case 'cvv':
                case 'cvc':
                    rules.validators = [this.validateCVV.bind(this)];
                    break;

                case 'expiry':
                case 'expiration':
                    rules.validators = [this.validateExpiry.bind(this)];
                    break;

                case 'number':
                    rules.validators = [this.validateNumber.bind(this)];
                    rules.min = parseFloat(field.getAttribute('min')) || -Infinity;
                    rules.max = parseFloat(field.getAttribute('max')) || Infinity;
                    break;

                case 'date':
                    rules.validators = [this.validateDate.bind(this)];
                    rules.minDate = field.getAttribute('min');
                    rules.maxDate = field.getAttribute('max');
                    break;

                case 'file':
                    rules.validators = [this.validateFile.bind(this)];
                    rules.accept = field.getAttribute('accept');
                    rules.maxSize = this.parseFileSize(field.getAttribute('data-max-size'));
                    break;
            }

            // Add custom validation attributes
            if (field.hasAttribute('data-validate')) {
                const customValidators = field.getAttribute('data-validate').split('|');
                customValidators.forEach(validator => {
                    const [name, param] = validator.split(':');
                    rules.custom.push({ name, param });
                });
            }

            return rules;
        }

        /**
         * Get field-specific error messages
         */
        getFieldSpecificMessages(fieldType, fieldName) {
            const messages = {
                required: this.getRequiredMessage(fieldName, fieldType),
                email: this.getEmailMessage(fieldName),
                phone: this.getPhoneMessage(fieldName),
                url: this.getURLMessage(fieldName),
                zipcode: this.getZipCodeMessage(fieldName),
                creditcard: this.getCreditCardMessage(fieldName),
                cvv: this.getCVVMessage(fieldName),
                expiry: this.getExpiryMessage(fieldName),
                number: this.getNumberMessage(fieldName),
                date: this.getDateMessage(fieldName),
                file: this.getFileMessage(fieldName),
                minLength: this.getMinLengthMessage(fieldName),
                maxLength: this.getMaxLengthMessage(fieldName),
                pattern: this.getPatternMessage(fieldName),
                custom: {}
            };

            return messages;
        }

        /**
         * Generate field-specific required messages
         */
        getRequiredMessage(fieldName, fieldType) {
            const fieldLabels = {
                'email': ['email address', 'email'],
                'phone': ['phone number', 'phone', 'telephone'],
                'name': ['name', 'full name'],
                'first name': ['first name'],
                'last name': ['last name'],
                'message': ['message', 'comments', 'feedback'],
                'subject': ['subject'],
                'company': ['company', 'organization'],
                'address': ['address'],
                'city': ['city'],
                'state': ['state', 'province'],
                'country': ['country'],
                'zipcode': ['zip code', 'postal code'],
                'password': ['password'],
                'confirm password': ['password confirmation'],
                'url': ['website URL', 'website', 'URL'],
                'creditcard': ['credit card number'],
                'cvv': ['CVV code', 'security code'],
                'expiry': ['expiration date'],
                'file': ['file', 'attachment']
            };

            // Find matching field label
            const lowerFieldName = fieldName.toLowerCase();
            for (const [key, labels] of Object.entries(fieldLabels)) {
                if (labels.some(label => lowerFieldName.includes(label))) {
                    return `Please enter your ${key}.`;
                }
            }

            // Default messages based on field type
            switch (fieldType) {
                case 'email':
                    return 'Please enter your email address.';
                case 'phone':
                case 'tel':
                    return 'Please enter your phone number.';
                case 'url':
                    return 'Please enter a website URL.';
                case 'file':
                    return 'Please select a file to upload.';
                case 'textarea':
                    return 'Please enter a message.';
                default:
                    return `Please enter ${this.addArticle(fieldName)}.`;
            }
        }

        /**
         * Get email validation messages
         */
        getEmailMessage(fieldName) {
            if (fieldName.toLowerCase().includes('work')) {
                return 'Please enter a valid work email address (e.g., john@company.com).';
            }
            return 'Please enter a valid email address (e.g., john@example.com).';
        }

        /**
         * Get phone validation messages
         */
        getPhoneMessage(fieldName) {
            if (fieldName.toLowerCase().includes('mobile')) {
                return 'Please enter a valid mobile phone number (e.g., (555) 123-4567).';
            }
            return 'Please enter a valid phone number with at least 10 digits.';
        }

        /**
         * Get URL validation messages
         */
        getURLMessage(fieldName) {
            return 'Please enter a complete website URL including http:// or https://';
        }

        /**
         * Get zip code validation messages
         */
        getZipCodeMessage(fieldName) {
            if (fieldName.toLowerCase().includes('postal')) {
                return 'Please enter a valid Canadian postal code (e.g., A1A 1A1).';
            }
            return 'Please enter a valid ZIP code (e.g., 12345 or 12345-6789).';
        }

        /**
         * Get credit card validation messages
         */
        getCreditCardMessage(fieldName) {
            return 'Please enter a valid credit card number (16 digits, no spaces or dashes).';
        }

        /**
         * Get CVV validation messages
         */
        getCVVMessage(fieldName) {
            return 'Please enter the 3-digit CVV code from the back of your card.';
        }

        /**
         * Get expiry date validation messages
         */
        getExpiryMessage(fieldName) {
            return 'Please enter a valid expiration date (MM/YY).';
        }

        /**
         * Get number validation messages
         */
        getNumberMessage(fieldName) {
            if (fieldName.toLowerCase().includes('age')) {
                return 'Please enter a valid age (numbers only).';
            }
            return 'Please enter a valid number.';
        }

        /**
         * Get date validation messages
         */
        getDateMessage(fieldName) {
            if (fieldName.toLowerCase().includes('birth')) {
                return 'Please enter a valid birth date.';
            }
            return 'Please enter a valid date.';
        }

        /**
         * Get file validation messages
         */
        getFileMessage(fieldName) {
            return 'Please select a valid file.';
        }

        /**
         * Get min length validation messages
         */
        getMinLengthMessage(fieldName) {
            if (fieldName.toLowerCase().includes('password')) {
                return 'Password must be at least {min} characters long for security.';
            }
            return `This field requires at least {min} characters.`;
        }

        /**
         * Get max length validation messages
         */
        getMaxLengthMessage(fieldName) {
            return `This field cannot exceed {max} characters.`;
        }

        /**
         * Get pattern validation messages
         */
        getPatternMessage(fieldName) {
            return 'Please enter information in the correct format.';
        }

        /**
         * Add article to field name
         */
        addArticle(fieldName) {
            const vowels = ['a', 'e', 'i', 'o', 'u'];
            const firstLetter = fieldName.charAt(0).toLowerCase();
            return `${vowels.includes(firstLetter) ? 'an' : 'a'} ${fieldName}`;
        }

        /**
         * Setup field event listeners
         */
        setupFieldEvents(field) {
            const fieldInfo = this.fields.get(field);

            // Blur validation (when user leaves field)
            field.addEventListener('blur', (e) => {
                this.validateFieldOnBlur(e.target);
            });

            // Real-time validation with debouncing
            field.addEventListener('input', (e) => {
                this.debounceValidation(e.target);
            });

            // Change validation (for selects, checkboxes, radio buttons)
            field.addEventListener('change', (e) => {
                this.validateFieldOnChange(e.target);
            });

            // Focus handling
            field.addEventListener('focus', (e) => {
                this.handleFieldFocus(e.target);
            });

            // Keyboard validation
            field.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
                    this.validateFieldOnChange(e.target);
                }
            });
        }

        /**
         * Setup real-time validation with debouncing
         */
        setupRealtimeValidation() {
            // Configure debounce timing based on field type
            this.debounceTimers.forEach((timer, field) => {
                const fieldInfo = this.fields.get(field);
                const debounceTime = this.getDebounceTime(fieldInfo.type);

                clearTimeout(timer);
            });
        }

        /**
         * Get debounce time for field type
         */
        getDebounceTime(fieldType) {
            const debounceTimes = {
                'email': 500,
                'phone': 300,
                'zipcode': 300,
                'creditcard': 200,
                'cvv': 0,
                'url': 500,
                'textarea': 800,
                'default': 300
            };

            return debounceTimes[fieldType] || debounceTimes.default;
        }

        /**
         * Debounced field validation
         */
        debounceValidation(field) {
            const fieldInfo = this.fields.get(field);
            const debounceTime = this.getDebounceTime(fieldInfo.type);

            // Clear existing timer
            if (this.debounceTimers.has(field)) {
                clearTimeout(this.debounceTimers.get(field));
            }

            // Set new timer
            const timer = setTimeout(() => {
                this.validateFieldOnInput(field);
            }, debounceTime);

            this.debounceTimers.set(field, timer);
        }

        /**
         * Validate field on blur
         */
        validateFieldOnBlur(field) {
            const fieldInfo = this.fields.get(field);

            // Only validate if field has been touched or has value
            if (field.value.trim() || fieldInfo.validationCount > 0) {
                this.validateField(field, 'blur');
            }
        }

        /**
         * Validate field on input (real-time)
         */
        validateFieldOnInput(field) {
            // Only validate if field has errors (avoid spamming valid fields)
            if (field.classList.contains('error') || field.classList.contains('warning')) {
                this.validateField(field, 'input');
            }
        }

        /**
         * Validate field on change
         */
        validateFieldOnChange(field) {
            this.validateField(field, 'change');
        }

        /**
         * Handle field focus
         */
        handleFieldFocus(field) {
            // Clear errors on focus for better UX
            if (field.classList.contains('error')) {
                this.clearFieldError(field);
            }
        }

        /**
         * Main field validation method
         */
        validateField(field, trigger = 'blur') {
            const fieldInfo = this.fields.get(field);
            const rules = this.validationRules.get(field);
            const value = field.value.trim();

            fieldInfo.validationCount++;
            fieldInfo.lastValidated = new Date();

            const validationResult = {
                field: field,
                isValid: true,
                errors: [],
                warnings: [],
                trigger: trigger
            };

            // Required field validation
            if (rules.required && !value) {
                validationResult.isValid = false;
                validationResult.errors.push({
                    type: 'required',
                    message: rules.messages.required
                });
            }

            // Skip other validations if field is empty and not required
            if (!value && !rules.required) {
                this.updateFieldValidation(field, validationResult);
                return validationResult;
            }

            // Length validations
            this.validateFieldLength(value, rules, validationResult);

            // Pattern validation
            this.validateFieldPattern(value, rules, validationResult);

            // Type-specific validations
            this.validateFieldType(value, rules, validationResult);

            // Custom validations
            this.validateFieldCustom(value, rules, validationResult);

            // Update field state
            this.updateFieldValidation(field, validationResult);

            // Announce validation result for accessibility
            this.announceValidationResult(field, validationResult);

            return validationResult;
        }

        /**
         * Validate field length
         */
        validateFieldLength(value, rules, result) {
            if (rules.minLength > 0 && value.length < rules.minLength) {
                result.isValid = false;
                result.errors.push({
                    type: 'minLength',
                    message: rules.messages.minLength.replace('{min}', rules.minLength)
                });
            }

            if (rules.maxLength < Infinity && value.length > rules.maxLength) {
                result.isValid = false;
                result.errors.push({
                    type: 'maxLength',
                    message: rules.messages.maxLength.replace('{max}', rules.maxLength)
                });
            }
        }

        /**
         * Validate field pattern
         */
        validateFieldPattern(value, rules, result) {
            if (rules.pattern && !new RegExp(rules.pattern).test(value)) {
                result.isValid = false;
                result.errors.push({
                    type: 'pattern',
                    message: rules.messages.pattern
                });
            }
        }

        /**
         * Validate field type
         */
        validateFieldType(value, rules, result) {
            if (rules.validators) {
                rules.validators.forEach(validator => {
                    const validation = validator(value, result.field);
                    if (!validation.isValid) {
                        result.isValid = false;
                        result.errors.push({
                            type: validation.type || 'type',
                            message: validation.message
                        });
                    }
                });
            }
        }

        /**
         * Email validation
         */
        validateEmail(value, field) {
            const emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

            if (!emailRegex.test(value)) {
                return {
                    isValid: false,
                    type: 'email',
                    message: this.validationRules.get(field).messages.email
                };
            }

            // Additional checks
            const parts = value.split('@');
            if (parts.length !== 2 || parts[0].length === 0 || parts[1].length === 0) {
                return {
                    isValid: false,
                    type: 'email',
                    message: this.validationRules.get(field).messages.email
                };
            }

            const domain = parts[1];
            if (!domain.includes('.') || domain.split('.').some(part => part.length === 0)) {
                return {
                    isValid: false,
                    type: 'email',
                    message: 'Please enter a valid email domain (e.g., example.com).'
                };
            }

            return { isValid: true };
        }

        /**
         * Phone validation
         */
        validatePhone(value, field) {
            const phoneRegex = /^[\d\s\-\+\(\)]+$/;
            const digits = value.replace(/\D/g, '');

            if (!phoneRegex.test(value) || digits.length < 10) {
                return {
                    isValid: false,
                    type: 'phone',
                    message: this.validationRules.get(field).messages.phone
                };
            }

            return { isValid: true };
        }

        /**
         * URL validation
         */
        validateURL(value, field) {
            try {
                const url = new URL(value);

                // Check protocol
                if (!['http:', 'https:'].includes(url.protocol)) {
                    return {
                        isValid: false,
                        type: 'url',
                        message: 'URL must start with http:// or https://'
                    };
                }

                // Check domain
                if (!url.hostname || !url.hostname.includes('.')) {
                    return {
                        isValid: false,
                        type: 'url',
                        message: 'Please enter a valid website domain'
                    };
                }

                return { isValid: true };
            } catch (error) {
                return {
                    isValid: false,
                    type: 'url',
                    message: this.validationRules.get(field).messages.url
                };
            }
        }

        /**
         * Zip code validation
         */
        validateZipCode(value, field) {
            const usZipRegex = /^\d{5}(-\d{4})?$/;
            const caPostalRegex = /^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/;

            if (!usZipRegex.test(value) && !caPostalRegex.test(value)) {
                return {
                    isValid: false,
                    type: 'zipcode',
                    message: this.validationRules.get(field).messages.zipcode
                };
            }

            return { isValid: true };
        }

        /**
         * Credit card validation
         */
        validateCreditCard(value, field) {
            const digits = value.replace(/\D/g, '');

            if (digits.length < 13 || digits.length > 19) {
                return {
                    isValid: false,
                    type: 'creditcard',
                    message: this.validationRules.get(field).messages.creditcard
                };
            }

            // Luhn algorithm check
            let sum = 0;
            let isEven = false;

            for (let i = digits.length - 1; i >= 0; i--) {
                let digit = parseInt(digits[i]);

                if (isEven) {
                    digit *= 2;
                    if (digit > 9) {
                        digit -= 9;
                    }
                }

                sum += digit;
                isEven = !isEven;
            }

            if (sum % 10 !== 0) {
                return {
                    isValid: false,
                    type: 'creditcard',
                    message: 'Please enter a valid credit card number.'
                };
            }

            return { isValid: true };
        }

        /**
         * CVV validation
         */
        validateCVV(value, field) {
            const digits = value.replace(/\D/g, '');

            if (digits.length !== 3 && digits.length !== 4) {
                return {
                    isValid: false,
                    type: 'cvv',
                    message: this.validationRules.get(field).messages.cvv
                };
            }

            return { isValid: true };
        }

        /**
         * Expiry date validation
         */
        validateExpiry(value, field) {
            const expiryRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;

            if (!expiryRegex.test(value)) {
                return {
                    isValid: false,
                    type: 'expiry',
                    message: this.validationRules.get(field).messages.expiry
                };
            }

            const [month, year] = value.split('/').map(Number);
            const currentDate = new Date();
            const currentYear = currentDate.getFullYear() % 100;
            const currentMonth = currentDate.getMonth() + 1;

            if (year < currentYear || (year === currentYear && month < currentMonth)) {
                return {
                    isValid: false,
                    type: 'expiry',
                    message: 'Card has expired. Please enter a future expiration date.'
                };
            }

            return { isValid: true };
        }

        /**
         * Number validation
         */
        validateNumber(value, field) {
            const num = parseFloat(value);

            if (isNaN(num)) {
                return {
                    isValid: false,
                    type: 'number',
                    message: this.validationRules.get(field).messages.number
                };
            }

            const rules = this.validationRules.get(field);

            if (num < rules.min) {
                return {
                    isValid: false,
                    type: 'min',
                    message: `Value must be at least ${rules.min}.`
                };
            }

            if (num > rules.max) {
                return {
                    isValid: false,
                    type: 'max',
                    message: `Value must be no more than ${rules.max}.`
                };
            }

            return { isValid: true };
        }

        /**
         * Date validation
         */
        validateDate(value, field) {
            const date = new Date(value);

            if (isNaN(date.getTime())) {
                return {
                    isValid: false,
                    type: 'date',
                    message: this.validationRules.get(field).messages.date
                };
            }

            const rules = this.validationRules.get(field);

            if (rules.minDate) {
                const minDate = new Date(rules.minDate);
                if (date < minDate) {
                    return {
                        isValid: false,
                        type: 'minDate',
                        message: `Date must be on or after ${minDate.toLocaleDateString()}.`
                    };
                }
            }

            if (rules.maxDate) {
                const maxDate = new Date(rules.maxDate);
                if (date > maxDate) {
                    return {
                        isValid: false,
                        type: 'maxDate',
                        message: `Date must be on or before ${maxDate.toLocaleDateString()}.`
                    };
                }
            }

            return { isValid: true };
        }

        /**
         * File validation
         */
        validateFile(value, field) {
            const files = field.files;

            if (files.length === 0) {
                return { isValid: true }; // Empty is handled by required validation
            }

            const rules = this.validationRules.get(field);

            for (const file of files) {
                // File type validation
                if (rules.accept && !this.isFileTypeAccepted(file, rules.accept)) {
                    return {
                        isValid: false,
                        type: 'fileType',
                        message: `File "${file.name}" is not an accepted file type.`
                    };
                }

                // File size validation
                if (rules.maxSize && file.size > rules.maxSize) {
                    return {
                        isValid: false,
                        type: 'fileSize',
                        message: `File "${file.name}" is too large. Maximum size is ${this.formatFileSize(rules.maxSize)}.`
                    };
                }
            }

            return { isValid: true };
        }

        /**
         * Check if file type is accepted
         */
        isFileTypeAccepted(file, accept) {
            const acceptedTypes = accept.split(',').map(type => type.trim());
            const fileType = file.type;
            const fileName = file.name.toLowerCase();

            return acceptedTypes.some(acceptedType => {
                if (acceptedType.startsWith('.')) {
                    return fileName.endsWith(acceptedType.toLowerCase());
                }
                return fileType === acceptedType;
            });
        }

        /**
         * Parse file size string
         */
        parseFileSize(sizeStr) {
            if (!sizeStr) return null;

            const units = {
                'B': 1,
                'KB': 1024,
                'MB': 1024 * 1024,
                'GB': 1024 * 1024 * 1024
            };

            const match = sizeStr.match(/^(\d+(?:\.\d+)?)\s*(B|KB|MB|GB)$/i);
            if (match) {
                const [, size, unit] = match;
                return parseFloat(size) * units[unit.toUpperCase()];
            }

            return null;
        }

        /**
         * Format file size
         */
        formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';

            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));

            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        /**
         * Validate custom rules
         */
        validateFieldCustom(value, rules, result) {
            rules.custom.forEach(rule => {
                const validation = this.validateCustomRule(value, rule);
                if (!validation.isValid) {
                    result.isValid = false;
                    result.errors.push({
                        type: 'custom',
                        customType: rule.name,
                        message: validation.message
                    });
                }
            });
        }

        /**
         * Validate custom rule
         */
        validateCustomRule(value, rule) {
            switch (rule.name) {
                case 'match':
                    return this.validateFieldMatch(value, rule.param);
                case 'different':
                    return this.validateFieldDifferent(value, rule.param);
                case 'alphanumeric':
                    return this.validateAlphanumeric(value);
                case 'letters':
                    return this.validateLetters(value);
                case 'strong':
                    return this.validateStrongPassword(value);
                default:
                    return { isValid: true };
            }
        }

        /**
         * Validate field matching
         */
        validateFieldMatch(value, fieldName) {
            const targetField = this.form.querySelector(`[name="${fieldName}"], #${fieldName}`);

            if (!targetField || targetField.value !== value) {
                return {
                    isValid: false,
                    message: `This field must match ${fieldName}.`
                };
            }

            return { isValid: true };
        }

        /**
         * Validate field different from
         */
        validateFieldDifferent(value, fieldName) {
            const targetField = this.form.querySelector(`[name="${fieldName}"], #${fieldName}`);

            if (targetField && targetField.value === value) {
                return {
                    isValid: false,
                    message: `This field must be different from ${fieldName}.`
                };
            }

            return { isValid: true };
        }

        /**
         * Validate alphanumeric
         */
        validateAlphanumeric(value) {
            if (!/^[a-zA-Z0-9]+$/.test(value)) {
                return {
                    isValid: false,
                    message: 'This field can only contain letters and numbers.'
                };
            }

            return { isValid: true };
        }

        /**
         * Validate letters only
         */
        validateLetters(value) {
            if (!/^[a-zA-Z\s]+$/.test(value)) {
                return {
                    isValid: false,
                    message: 'This field can only contain letters and spaces.'
                };
            }

            return { isValid: true };
        }

        /**
         * Validate strong password
         */
        validateStrongPassword(value) {
            const checks = {
                length: value.length >= 8,
                uppercase: /[A-Z]/.test(value),
                lowercase: /[a-z]/.test(value),
                numbers: /\d/.test(value),
                special: /[!@#$%^&*(),.?":{}|<>]/.test(value)
            };

            const failedChecks = Object.keys(checks).filter(key => !checks[key]);

            if (failedChecks.length > 0) {
                const messages = {
                    length: 'at least 8 characters',
                    uppercase: 'one uppercase letter',
                    lowercase: 'one lowercase letter',
                    numbers: 'one number',
                    special: 'one special character'
                };

                const requirements = failedChecks.map(check => messages[check]).join(', ');
                return {
                    isValid: false,
                    message: `Password must include ${requirements}.`
                };
            }

            return { isValid: true };
        }

        /**
         * Update field validation state
         */
        updateFieldValidation(field, result) {
            const fieldInfo = this.fields.get(field);
            fieldInfo.isValid = result.isValid;

            // Update field classes
            field.classList.remove('error', 'warning', 'success', 'validating');

            if (result.isValid) {
                field.classList.add('success');
            } else if (result.errors.length > 0) {
                field.classList.add('error');
            } else if (result.warnings.length > 0) {
                field.classList.add('warning');
            }

            // Update field ARIA attributes
            this.updateFieldARIA(field, result);

            // Display errors/warnings
            this.displayFieldMessages(field, result);
        }

        /**
         * Update field ARIA attributes
         */
        updateFieldARIA(field, result) {
            if (result.isValid) {
                field.removeAttribute('aria-invalid');
                field.removeAttribute('aria-describedby');
            } else {
                field.setAttribute('aria-invalid', 'true');

                const errorId = this.getOrCreateErrorContainer(field);
                field.setAttribute('aria-describedby', errorId);
            }
        }

        /**
         * Get or create error container
         */
        getOrCreateErrorContainer(field) {
            let container = field.parentNode.querySelector('.field-validation-messages');

            if (!container) {
                container = document.createElement('div');
                container.className = 'field-validation-messages';
                container.setAttribute('role', 'alert');
                container.setAttribute('aria-live', 'polite');
                container.id = `${field.name || field.id}-messages`;

                field.parentNode.appendChild(container);
            }

            return container.id;
        }

        /**
         * Display field validation messages
         */
        displayFieldMessages(field, result) {
            const container = field.parentNode.querySelector('.field-validation-messages');

            if (!container) return;

            // Clear existing messages
            container.innerHTML = '';

            // Add error messages
            if (result.errors.length > 0) {
                const errorList = document.createElement('ul');
                errorList.className = 'validation-errors';

                result.errors.forEach(error => {
                    const li = document.createElement('li');
                    li.textContent = error.message;
                    li.className = 'validation-error';
                    errorList.appendChild(li);
                });

                container.appendChild(errorList);
            }

            // Add warning messages
            if (result.warnings.length > 0) {
                const warningList = document.createElement('ul');
                warningList.className = 'validation-warnings';

                result.warnings.forEach(warning => {
                    const li = document.createElement('li');
                    li.textContent = warning.message;
                    li.className = 'validation-warning';
                    warningList.appendChild(li);
                });

                container.appendChild(warningList);
            }

            // Add success indicator
            if (result.isValid && field.value.trim()) {
                const successDiv = document.createElement('div');
                successDiv.className = 'validation-success';
                successDiv.textContent = '✓ Valid';
                container.appendChild(successDiv);
            }

            // Make container visible
            if (result.errors.length > 0 || result.warnings.length > 0) {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }

        /**
         * Clear field error
         */
        clearFieldError(field) {
            field.classList.remove('error', 'warning');
            field.removeAttribute('aria-invalid');

            const container = field.parentNode.querySelector('.field-validation-messages');
            if (container) {
                container.style.display = 'none';
            }
        }

        /**
         * Announce validation result for screen readers
         */
        announceValidationResult(field, result) {
            if (result.errors.length > 0) {
                const message = `Validation error for ${this.fields.get(field).name}: ${result.errors[0].message}`;
                this.announceToScreenReader(message, 'assertive');
            }
        }

        /**
         * Announce message to screen reader
         */
        announceToScreenReader(message, politeness = 'polite') {
            // Dispatch announcement event
            document.dispatchEvent(new CustomEvent('accessibility:announce', {
                detail: { message, politeness }
            }));

            // Fallback: create temporary live region
            const liveRegion = document.createElement('div');
            liveRegion.setAttribute('aria-live', politeness);
            liveRegion.setAttribute('aria-atomic', 'true');
            liveRegion.className = 'sr-only';
            liveRegion.textContent = message;

            document.body.appendChild(liveRegion);

            setTimeout(() => {
                liveRegion.remove();
            }, 1000);
        }

        /**
         * Setup accessibility enhancements
         */
        setupAccessibilityEnhancements() {
            this.setupFieldLabels();
            this.setupFieldDescriptions();
            this.setupFormLabels();
        }

        /**
         * Setup field labels
         */
        setupFieldLabels() {
            this.fields.forEach((fieldInfo, field) => {
                this.enhanceFieldAccessibility(field);
            });
        }

        /**
         * Enhance field accessibility
         */
        enhanceFieldAccessibility(field) {
            // Ensure field has proper labeling
            if (!this.hasProperLabel(field)) {
                this.addMissingLabel(field);
            }

            // Add validation state indicators
            this.addValidationIndicators(field);
        }

        /**
         * Check if field has proper label
         */
        hasProperLabel(field) {
            if (field.hasAttribute('aria-label') || field.hasAttribute('aria-labelledby')) {
                return true;
            }

            const id = field.id;
            if (id) {
                return !!document.querySelector(`label[for="${id}"]`);
            }

            return false;
        }

        /**
         * Add missing label for field
         */
        addMissingLabel(field) {
            const fieldInfo = this.fields.get(field);
            const id = field.id || this.generateFieldId(field);
            field.id = id;

            // Look for existing label text
            const wrapper = field.closest('.form-group, .field-group');
            let labelText = fieldInfo.name;

            if (wrapper) {
                const existingLabel = wrapper.querySelector('label');
                if (existingLabel && !existingLabel.getAttribute('for')) {
                    existingLabel.setAttribute('for', id);
                    return;
                }

                const heading = wrapper.querySelector('h1, h2, h3, h4, h5, h6, .field-label');
                if (heading) {
                    labelText = heading.textContent.trim();
                }
            }

            // Create visual label if needed
            if (!document.querySelector(`label[for="${id}"]`)) {
                const label = document.createElement('label');
                label.setAttribute('for', id);
                label.textContent = labelText;
                label.className = 'generated-label visually-hidden';

                field.parentNode.insertBefore(label, field);
            }
        }

        /**
         * Add validation indicators
         */
        addValidationIndicators(field) {
            // Add aria-required attribute
            if (field.hasAttribute('required')) {
                field.setAttribute('aria-required', 'true');
            }

            // Add describedby for help text
            this.addDescribedBy(field);
        }

        /**
         * Add describedby attribute
         */
        addDescribedBy(field) {
            const wrapper = field.closest('.form-group, .field-group');
            if (!wrapper) return;

            const describedbyElements = [];

            // Help text
            const helpText = wrapper.querySelector('.help-text, .description, .field-description');
            if (helpText) {
                helpText.id = helpText.id || this.generateFieldId(helpText, 'help');
                describedbyElements.push(helpText.id);
            }

            // Error container
            const errorContainer = wrapper.querySelector('.field-validation-messages');
            if (errorContainer) {
                errorContainer.id = errorContainer.id || this.generateFieldId(errorContainer, 'errors');
                describedbyElements.push(errorContainer.id);
            }

            if (describedbyElements.length > 0) {
                field.setAttribute('aria-describedby', describedbyElements.join(' '));
            }
        }

        /**
         * Generate unique field ID
         */
        generateFieldId(element, suffix = '') {
            const base = element.name || element.className || element.tagName.toLowerCase();
            const timestamp = Date.now();
            const random = Math.random().toString(36).substr(2, 5);
            return `${base}${suffix ? '-' + suffix : ''}-${timestamp}-${random}`;
        }

        /**
         * Setup progressive enhancement
         */
        setupProgressiveEnhancement() {
            // Add CSS classes for enhanced styling
            this.form.classList.add('enhanced-validation');

            // Add data attributes for JavaScript detection
            this.form.setAttribute('data-validation-enhanced', 'true');

            // Setup fallback for no-JavaScript
            this.setupNoJSHandling();
        }

        /**
         * Setup no-JavaScript handling
         */
        setupNoJSHandling() {
            // Remove no-js class
            document.documentElement.classList.remove('no-js');
            document.documentElement.classList.add('js');
        }

        /**
         * Setup custom validation attributes
         */
        setupCustomValidation() {
            // Listen for custom validation events
            document.addEventListener('form:validateField', (e) => {
                if (e.detail.form === this.form) {
                    this.validateField(e.detail.field);
                }
            });

            // Listen for form validation requests
            document.addEventListener('form:validate', (e) => {
                if (e.detail.form === this.form) {
                    this.validateForm();
                }
            });
        }

        /**
         * Validate entire form
         */
        validateForm() {
            this.isValidating = true;
            this.submissionAttempts++;

            const results = [];
            let formIsValid = true;

            // Validate all fields
            this.fields.forEach((fieldInfo, field) => {
                const result = this.validateField(field, 'form');
                results.push(result);

                if (!result.isValid) {
                    formIsValid = false;
                }
            });

            // Focus first error field
            if (!formIsValid) {
                const firstErrorResult = results.find(result => !result.isValid);
                const firstErrorField = firstErrorResult ? firstErrorResult.field : null;
                if (firstErrorField) {
                    firstErrorField.focus();
                }
            }

            this.isValidating = false;

            return {
                isValid: formIsValid,
                results: results,
                submissionAttempts: this.submissionAttempts
            };
        }

        /**
         * Get form validation summary
         */
        getValidationSummary() {
            const errors = [];
            const warnings = [];

            this.fields.forEach((fieldInfo, field) => {
                const container = field.parentNode.querySelector('.field-validation-messages');
                if (container) {
                    const errorMessages = container.querySelectorAll('.validation-error');
                    const warningMessages = container.querySelectorAll('.validation-warning');

                    errorMessages.forEach(msg => {
                        errors.push({
                            field: fieldInfo.name,
                            message: msg.textContent
                        });
                    });

                    warningMessages.forEach(msg => {
                        warnings.push({
                            field: fieldInfo.name,
                            message: msg.textContent
                        });
                    });
                }
            });

            return { errors, warnings };
        }

        /**
         * Reset form validation
         */
        resetValidation() {
            this.fields.forEach((fieldInfo, field) => {
                field.classList.remove('error', 'warning', 'success');
                field.removeAttribute('aria-invalid');

                const container = field.parentNode.querySelector('.field-validation-messages');
                if (container) {
                    container.innerHTML = '';
                    container.style.display = 'none';
                }
            });

            this.submissionAttempts = 0;
        }

        /**
         * Destroy validator
         */
        destroy() {
            // Clear debounce timers
            this.debounceTimers.forEach(timer => clearTimeout(timer));
            this.debounceTimers.clear();

            // Clear field data
            this.fields.clear();
            this.validationRules.clear();

            // Remove event listeners
            // (Note: This is a simplified version - in production, you'd want to track and remove specific listeners)
        }
    }

    /**
     * Initialize enhanced form validation
     */
    function initEnhancedFormValidation() {
        const forms = document.querySelectorAll('form[data-enhance-validation], .enhanced-form');

        forms.forEach(form => {
            // Avoid re-initializing
            if (form.hasAttribute('data-validation-initialized')) {
                return;
            }

            // Create validator instance
            const validator = new EnhancedFormValidator(form);

            // Store reference
            form._enhancedValidator = validator;
            form.setAttribute('data-validation-initialized', 'true');

            // Setup form submission handling
            form.addEventListener('submit', (e) => {
                const validation = validator.validateForm();

                if (!validation.isValid) {
                    e.preventDefault();
                    e.stopPropagation();

                    // Announce validation errors
                    const errorCount = validation.results.filter(r => !r.isValid).length;
                    const message = `Form validation failed with ${errorCount} error${errorCount !== 1 ? 's' : ''}. Please check the highlighted fields.`;

                    document.dispatchEvent(new CustomEvent('accessibility:announce', {
                        detail: { message, politeness: 'assertive' }
                    }));

                    // Scroll to first error
                    const firstError = validation.results.find(r => !r.isValid);
                    if (firstError) {
                        firstError.field.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }
            });

            // Listen for form reset
            form.addEventListener('reset', () => {
                validator.resetValidation();
            });
        });

        // Expose validator to global scope for external access
        window.EnhancedFormValidator = EnhancedFormValidator;
    }

    /**
     * Initialize on DOM ready
     */
    function onDOMReady() {
        initEnhancedFormValidation();
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', onDOMReady);
    } else {
        onDOMReady();
    }

})();
<?php
/* language file: english */

/* page titles */
define('PAGE_TITLE_REGISTRATION','registration of new customer');
define('PAGE_TITLE_LOGIN_CUSTOMER','customer login');
define('PAGE_TITLE_SHOPPINGCART','shoppingcart');
define('PAGE_TITLE_CHECKOUT','checkout');
define('PAGE_TITLE_CUSTOMERDATA', 'my data');
define('PAGE_TITLE_CUSTOMERPRODUCTS', 'my products');
define('PAGE_TITLE_CUSTOMERINVOICES', 'my invoices');
define('PAGE_TITLE_LOGIN_BACKEND','login for shop administration');
define('PAGE_TITLE_SHOPMAINTENANCE_BACKEND','shop options');

/* general texts */
define('IS_MANDATORY_FIELD','this is a mandatory field!');
define('LINK_BACK', 'back');
define('LINK_DELETE', 'delete');
define('LINK_DISPLAY', 'display');
define('LABEL_ACTIVE','active');
define('LABEL_INACTIVE','inactiv');
define('BUTTON_SAVE','save');


/* -----------------------------  Backend   ------------------------------------------------ */


/* registration process */
define ('SHIPPING_ADDRESS', 'shipping address');
define('LABEL_GENDER','gender');
define('LABEL_TITLE','title');
define('LABEL_FIRST_NAME','first name');
define('LABEL_LAST_NAME','last name');
define('LABEL_COMPANY','company');

define('LABEL_BILLING_ADDRESS','billing address');
define('LABEL_TELEPHONE','tel no');
define('LABEL_FAX','fax no');
define('LABEL_EMAIL','e-mail');
define('LABEL_PASSWORD','password');
define('LABEL_PASSWORDAGAIN','repeat password ');
define('LABEL_STREET','street');
define('LABEL_STREETNUMBER','street number');
define('LABEL_POSTCODE','postcode');
define('LABEL_CITY','city');
define('LABEL_COUNTRY','country');

define('FIELDSET_GENERAL_INFORMATION','general information');
define('FIELDSET_CONTACT_INFORMATION','contact details');

define('FIELDSET_CUSTOMER_GENERAL_INFORMATION','general information');
define('FIELDSET_CUSTOMER_CONTACT_INFORMATION','contact');
define('FIELDSET_CUSTOMER_ADDRESS_INFORMATION','address');

define('FIELDSET_CUSTOMER_BILLING_ADDRESS_INFORMATION','Billing Address');

define('SELECT_CUSTOMER_GENDER_MALE','Mr.');
define('SELECT_CUSTOMER_GENDER_FEMALE','Mrs.');
define('SELECT_GENDER_MALE','Mr.');
define('SELECT_GENDER_FEMALE','Mrs.');

/* Contact form */
define('LEGEND_CONTACT_FORM','cantact form');
define('RADIO_VALUE_QUESTION','question');
define('RADIO_VALUE_PROBLEM','problem');
define('RADIO_VALUE_FEEDBACK','feedback');
define('LABEL_YOUR_MESSAGE','your message');
define('LABEL_SEND','send');

/* Login process */
define('FIELDSET_LOGIN_FORM_CUSTOMER','customer login');
define('LINK_REGISTRATION','register');

/* shopping cart */
define('HEADING_PRODUCT','product');
define('HEADING_QUANTITY','quantity');
define('HEADING_AMOUNT','amount');

define('BUTTON_MORE', 'More');
define('BUTTON_ADD_TO_CART', 'add to shopping cart');
define('BUTTON_CREATE_ACCOUNT','create account');
define('BUTTON_LOGIN_CUSTOMER','login');
define('BUTTON_LOGOUT_CUSTOMER','logout');
define('BUTTON_EDIT_CUSTOMER','change data ');
define('BUTTON_CHECKOUT','checkout');
define('BUTTON_CHECKOUT_NEXT','next');
define('IMG_TITEL_REMOVE', 'remove');

/* message texts */
define('WARNING_SHORT_PASSWORD','The entered password is too short!');
define('WARNING_PASSWORD_NOT_MATCHING','The entered passwords do not match!');
define('WARNING_INVALID_TELEPHONE','Please enter a valid telephone number!');
define('WARNING_INVALID_FAX','Please enter a valid fax number!');
define('WARNING_INVALID_EMAIL','The entered e-mail address is not valid!');
define('WARNING_EMAIL_ALREADY_EXISTS','There is already a customer who uses the entered e-mail address!');
define('WARNING_FILL_ALL_MANDATORY_FIELDS','Please fill all mandatory fields!');
define('WARNING_STILL_LOGGED_IN','You are already logged in!');
define('WARNING_WRONG_CREDENTIALS','The stated login credentials are not correct. Please check your input.');
define('WARNING_NOT_LOGGED_IN','You are not logged in or your session is expired. Please login!');
define('WARNING_CONTENT_NOT_FOUND','The requested site could not be found!');
define('WARNING_SERVER_NO_SERVER_AVAILABLE','For product %s there is no server availible. That is why we unfortunately could not perform your order.');
define('WARNING_SERVER_NOT_ABLE_TO_ALLOCATE','An Error has occurred while booking the product on the server!');
define('WARNING_SERVER_NOT_ABLE_TO_FREE','An Error has occurred while releasing the product from the server!');
define('WARNING_CHECKOUT_PLEASE_ACCEPT_TERMS','To continue it is necessary to accept our general terms and conditions!');
define('WARNING_INVOICE_NOT_AUTHORIZED','You are not authorized to open this invoice!');
define('WARNING_DELETE_CONTRACT_CONFIRM','Are you sure to terminate the contract?');
define('WARNING_REGISTRATION_RESET_FORM_CONFIRM','Are you sure to delete all entries?');
define('WARNING_INVALID_EMAIL_ADDRESS','Invalid email address!');
define('WARNING_INVALID_PHONE_NO','Invalid telephone number!');

define('SUCCESS_CONTRACT_TERMINATION','The product was successfully terminated by %s.');
define('SUCCESS_PRODUCT_TO_SHOPPINGCART', 'The product was add to the shopping cart successfully.');

define('ERROR_SERVER_NOT_AVAILABLE','For product %s there is no server availible. For the moment there could not take place a purchase.');

/* product texts */
define('PRODUCT_QUANTITY', 'quantity');
define('PRODUCT_CONTRACT_PERIODE','contract periode');
define('PRODUCT_PRICE','price');
define('PRODUCT_DETAILS','details');
define('PRODUCT_DETAILS_MORE','more');
define('PRODUCT_DETAILS_LESS','less');

/* main menu texts */
define('VIEW_MENU_HELP','help');
define('VIEW_MENU_CONTACT','contact');
define('VIEW_MENU_IMPRINT', 'imprint');
define('VIEW_MENU_HOME', 'home');
define('VIEW_MENU_PRODUCTS', 'products');
define('VIEW_MENU_CUSTOMERCENTER', 'customercenter');
define('VIEW_MENU_SHOPPING_CART','shopping cart');

/* customer center */
define('EXPLANATION_NUMBER_OF_INVOICES','%d invoices exist for you.');
define('TABLE_HEADING_INVOICE_INVOICE_NUMBER','invoice number');
define('TABLE_HEADING_INVOICE_ISSUE_DATE','date');
define('TABLE_HEADING_INVOICE_AMOUNT','amount');
define('TABLE_HEADING_INVOICE_INVOICE_STATUS','status');

define('EXPLANATION_NUMBER_OF_CONTRACTS','Currently you are under %d contracts with us.');
define('TABLE_HEADING_CONTRACT_PRODUCT','product');
define('TABLE_HEADING_CONTRACT_START_DATE','start_date');
define('TABLE_HEADING_CONTRACT_EXPIRATION_DATE','expiration date');
define('TABLE_HEADING_CONTRACT_CONTRACT_PERIODE','contract periode');
define('TABLE_HEADING_CONTRACT_EXPIRATION_DATE_UNIT','month(s)');

define('LABEL_CONTRACT_TERMINATION_EXECUTION_DATE','terminated by %s');

/* customer menu texts */
define('VIEW_CMENU_MYDATA', 'my data');
define('VIEW_CMENU_MYPRODUCTS', 'my products');
define('VIEW_CMENU_MYINVOICES', 'my invoices');

/* customer data view */
define('LABEL_LOGIN_DATA', 'login data');
define('LABEL_B_ADDRESS', 'billing address');
define('LABEL_S_ADDRESS', 'shipping address');
define('LABEL_TEL', 'phone.');
define('LABEL_SAME_ADRESS', 'Same invoice address and billing address');
define('BUTTON_CHANGE_PW', 'change password');
define('MSG_CHANGES_SAVED', 'Your data was changed successfully!');

define('LINK_CANCEL_PRODUCT', 'terminate');

/* checkout process */
define('LABEL_ACCEPT_TERMS','I assure that I had read the general terms and conditions and accept them.');
define('HEADING_ORDER_OVERVIEW','order overview');
define('BUTTON_CHECKOUT_SEND_ORDER','send order');

/* communications */
define('NOTICE_COMMUNICATION_HTML_EMAIL','To display the email correctly, please use a html compatible email software!');
define('LABEL_COMMUNICATION_INVOICE_SUBJECT','your invoive %s');
define('LABEL_COMMUNICATION_INVOICE_SUBJECT_ADMIN','invoice %s');

/* help / contact */
define('MSG_SUCCESSFULLY_SENT','Your message was successfully sent to the shop owner!');
define('HEADING_SITEMAP', 'sitemap');

/* invoice */
define('INVOICE_LABEL_INVOICE','invoice');
define('INVOICE_BANK_CONTACT','bank contact');
define('INVOICE_NET_AMOUNT','net amount');
define('INVOICE_TAX_RATE','sales tax');
define('INVOICE_INVOICE_AMOUNT','invoice amount');
define('INVOICE_CONTINUANCE','continuation of invoice on next page.');
define('INVOICE_LABEL_POSITION','pos');
define('INVOICE_LABEL_TOTAL','total');

/* -----------------------------  Backend   ------------------------------------------------ */

/* buttons */
define('BUTTON_LOGOUT_BACKEND','logout');
define('BUTTON_LOGIN_BACKEND','login');
define('BUTTON_MODIFY_CUSTOMIZING_BACKEND','change customizing');
define('BUTTON_SAVE_CUSTOMIZING_BACKEND','save customizing');

define('BUTTON_CREATE_CONTENT','create new content');
define('BUTTON_CREATE_NEW_PRODUCT','create new product');
define('BUTTON_NEW_ATTR_FOR_PROD', 'add new attribute');
define('BUTTON_SAVE_ATTR_FOR_PROD', 'add attribute to product');
define('BUTTON_CREATE_NEW_PRODUCT_ATTRIBUTE', 'create new product attribute');
define('BUTTON_SAVE_CHANGES', 'save changes');
define('IMG_REMOVE_PRODUCT', 'remove product');
define('BUTTON_CREATE_PRODUCT_ATTRIBUTE', 'save attribute');
define('BUTTON_UPDATE_ADMIN_PASSWORD','change admin password');
define('BUTTON_CHANGE_SERVER', 'change server');
define('BUTTON_CREATE_SERVER', 'create server');

define('MSG_BACKEND_WELCOME', 'Welcome to the internal area of the shop owner!');
define('MSG_CUSTOMER_WELCOME', 'Welcome to the customer center');

define('LINK_EDIT_PRODUCT', 'edit');
define('LINK_TRANSLATE_PRODUCT', 'translate');
define('LINK_DEACTIVATE_PRODUCT', 'deactivate');
define('LINK_ACTIVATE_PRODUCT', 'activate');

define('LINK_SAVE_INVOICE_STATUS', 'save invoice status');

define('LABEL_MY_SHOP','my shop');
define('LABEL_MY_PRODUCTS','my products');
define('LABEL_MY_PRODUCTATTRIBUTES', 'my product attributes');
define('LABEL_MY_SERVERS','my servers');
define('LABEL_MY_CUSTOMERS','my customers');
define('LABEL_MY_INVOICES','my invoices');
define('LABEL_MY_CONTENT','my content');
define('LABEL_MY_STATISTICS','my statistics');
define('LABEL_MY_PASSWORD','change my password');

define('LABEL_PRODUCT_ID', 'product no. ');
define('LABEL_PRODUCT_LANGUAGE', 'language');
define('LABEL_PRODUCT_TITLE', 'title');
define('LABEL_PRODUCT_CONTRACT_PEROIDE', 'contract periode');
define('LABEL_PRODUCT_DESCRIPTION', 'decription');
define('LABEL_PRODUCT_QUANTITY', 'quantity');
define('LABEL_PRODUCT_PRICE', 'price');

define('LABEL_PRODUCT_ATTRIBUTE', 'attributes for product no.');
define('LABEL_PRODUCT_ATTRIBUTE_LANGUAGE', 'language');
define('LABEL_PRODUCT_ATTRIBUTE_DESCRIPTION', 'description');

define('LABEL_ATTRIBUTE', 'attribute');
define('LABEL_VALUE', 'value ');

define('LABEL_SERVER_NAME','server name');
define('LABEL_SERVER_MNGMNT_UI','server management UI');
define('LABEL_SERVER_IPV4','IPv4 address');
define('LABEL_SERVER_IPV6','IPv6 address');
define('LABEL_SERVER_TOTAL_SPACE','disk space (total)');
define('LABEL_SERVER_FREE_SPACE','disk space (free)');
define('LABEL_SERVER_AVAILABLE','Server available for selling options');
define('LABEL_SERVER_FROXLOR_USERNAME','Froxlor username');
define('LABEL_SERVER_FROXLOR_PASSWORD','Froxlor password');
define('LABEL_SERVER_FROXLOR_DB','Froxlor database');
define('LABEL_SERVER_FROXLOR_DB_HOST','Froxlor databas host');

define('LABEL_PASSWORD_NEW_ADMIN_PASSWORD','backend password');

define('TABLE_HEADING_CONTENT_TITLE','title');
define('TABLE_HEADING_CUSTOMER_CUSTOMER_NUMBER','customer number');
define('TABLE_HEADING_CUSTOMER_FIRST_NAME','first name');
define('TABLE_HEADING_CUSTOMER_LAST_NAME','last name');

define('TABLE_HEADING_PRODUCT_LANGUAGE', 'language');
define('TABLE_HEADING_PRODUCT_TITLE', 'title');
define('TABLE_HEADING_PRODUCT_CONTRACT_PERIODE', 'contract periode');
define('TABLE_HEADING_PRODUCT_DESCRIPTION', 'description');
define('TABLE_HEADING_PRODUCT_QUANTITY', 'quantity');
define('TABLE_HEADING_PRODUCT_PRICE', 'price');

define('TABLE_HEADING_SERVER_NAME', 'server name');
define('TABLE_HEADING_SERVER_DISK_SPACE', 'disk space');
define('TABLE_HEADING_SERVER_STATUS','status');

define('TABLE_HEADING_PRODUCT_ATTRIBUTE_LANGUAGE', 'language');
define('TABLE_HEADING_PRODUCT_ATTRIBUTE_DESCRIPTION', 'description');

define('FIELDSET_LOGIN_FORM_BACKEND','login to administration area');

define('FIELDSET_SERVER_SERVER_DATA','server data');
define('FIELDSET_SERVER_FROXLOR_DATA','Froxlor data');

define('EXPLANATION_CUSTOMIZING_ENTRIES','By the following entries you can customize the behaviour of your shop easily and add extra entries.');

define('EXPLANATION_NUMBER_OF_PRODUCTS','At the moment there are %d products in your language available for sale.');
define('EXPLANATION_NUMBER_OF_PRODUCT_ATTRIBUTES', 'At the moment there are %d product attributes in your language deposed in your system.');

define('EXPLANATION_NUMBER_OF_CUSTOMERS','At the moment you have %d customers.');
define('EXPLANATION_NUMBER_OF_SERVERS','At the moment there are %d servers available for selling options.');

define('EXPLANATION_CONTENT','Here you can administrate your content.');

define('INFO_MESSAGE_PRODUCT_ATTRIBUTE_ALREADY_EXISTS', 'Thies product attribute does already exist!');
define('INFO_MESSAGE_PRODUCT_ATTRIBUTE_UPDATE_SUCCESSFUL', 'The porduct attribute successfully changed successfully.');
define('INFO_MESSAGE_PRODUCT_ATTRIBUTE_UPDATE_FAILED', 'An error has occurred while updating a database entry');
define('INFO_MESSAGE_PRODUCT_ATTRIBUTE_CREATION_SUCCESSFUL', 'Product attribute was saved successfully.');
define('INFO_MESSAGE_PRODUCT_ATTRIBUTE_CREATION_FAILED', 'An error has occurred while creating the produkt attribute.');

define('INFO_MESSAGE_PRODUCT_ATTRIBUTE_SUCCESSFULLY_DELETED', 'Product attribute was deleted successfully.');
define('INFO_MESSAGE_PRODUCT_ATTRIBUTE_DELETION_FAILED', 'An error has occurred while deleting the producz attribute.');

define('INFO_MESSAGE_PRODUCT_ATTRIBUTE_SUCCESSFULLY_TRANSLATED', 'Product attribute was translated successfully.');
define('INFO_MESSAGE_PRODUCT_ATTRIBUTE_TRANSLATION_FAILED', 'An error has occurred while translating the product attribute.');
define('INFO_MESSAGE_PRODUCT_ATTRIBUTE_TRANSLATIONS_FOR_ALL_SUPPORTED_LANGUAGES_ALREADY_EXIST', 'All supported translations do already exist for this product attribute.');

define('INFO_MESSAGE_PRODUCT_CREATION_SUCCESSFUL', 'Product was saved successfully.');
define('INFO_MESSAGE_DB_ACTION_FAILED', 'An error has occurred while updating a database entry.');

define('INFO_MESSAGE_PRODUCT_UPDATE_SUCCESSFUL', 'The product was changed successfully.');
define('INFO_MESSAGE_PRODUCT_UPDATE_FAILED', 'An error has occurred while updating a database entry');

define('INFO_MESSAGE_TRANSLATED_PRODUCT_ALREADY_EXISTS', 'This translation fpr product %d does already exist!');
define('INFO_MESSAGE_TRANSLATION_SUCCEEDED', 'Product %d was translated successfully.');
define('INFO_MESSAGE_PRODUCT_ALREADY_EXISTS', 'This product already exists!');

define('INFO_MESSAGE_PRODUCT_INFO_CREATION_SUCCESSFUL', 'The attribute was saved to the product successfully.');

define('WARNING_MESSAGE_SERVER_ALREADY_EXISTS', 'A server with exactly this IP address does already exist!');
define('ERROR_INVOICE_NOT_PAYED','Invoice %d is uncleared!');

define('INFO_MESSAGE_PRODUCT_STATE_CHANGE_SUCCESSFUL', 'Product state was changed successfully.');
define('INFO_MESSAGE_PRODUCT_SUCCESSFULLY_DELETED', 'Product was deleted successfully.');

define('INFO_MESSAGE_CUSTOMIZING_SAVED', 'Customizing was changed successfully.');

define('INFO_MESSAGE_CONTENT_UPDATED', 'Content was changed successfully.');
define('INFO_MESSAGE_CONTENT_CREATED', 'Content with the title was changed successfully.');

define('INFO_MESSAGE_INVOICE_STATUS_CHANGED', 'State of invoice was changed successfully.');
define('INFO_MESSAGE_PRODUCT_INFO_SUCCESSFULLY_DELETED', 'Product attribute was deleted successfully.');

define('INFO_MESSAGE_SERVER_CREATION_SUCCESSFUL', 'Server was created successfully.');
define('INFO_MESSAGE_SERVER_UPDATE_SUCCESSFUL', 'The server was changed successfully.');
define('INFO_MESSAGE_SERVER_SUCCESSFULLY_DELETED', 'Server was deleted successfully.');
define('INFO_MESSAGE_SERVER_DELETION_FAILED', 'An error has occurred while deleting the server.');

define('INFO_MESSAGE_PASSWORT_SUCCESSFULLY_CHANGED', 'Password was changed successfully!');
define('WARNING_MESSAGE_PASSWORT_CHANGE_ABORTED','An error has occurred while changing the password. Please try again later!');

?>

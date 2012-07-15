<?php
/* language file: german */

/* page titles */
define('PAGE_TITLE_REGISTRATION','Neukundenregistrierung');
define('PAGE_TITLE_LOGIN_CUSTOMER','Kundenanmeldung');
define('PAGE_TITLE_SHOPPINGCART','Warenkorb');
define('PAGE_TITLE_CHECKOUT','Kasse');
define('PAGE_TITLE_CUSTOMERDATA', 'Meine Daten');
define('PAGE_TITLE_CUSTOMERPRODUCTS', 'Meine Produkte');
define('PAGE_TITLE_CUSTOMERINVOICES', 'Meine Rechnungen');
define('PAGE_TITLE_LOGIN_BACKEND','Anmeldung für Shopeinstellungen');
define('PAGE_TITLE_SHOPMAINTENANCE_BACKEND','Shopeinstellungen');



/* general texts */
define('IS_MANDATORY_FIELD','Diese Eingabe ist eine Pflichtangabe!');
define('LINK_BACK', 'zurück');
define('LINK_DELETE', 'Löschen');
define('LINK_DISPLAY', 'Anzeigen');
define('LABEL_ACTIVE','Aktiv');
define('LABEL_INACTIVE','Inaktiv');
define('BUTTON_SAVE','Speichern');


/* -----------------------------  Backend   ------------------------------------------------ */


/* registration process */
define ('SHIPPING_ADDRESS', 'Lieferadresse');
define('LABEL_GENDER','Anrede');
define('LABEL_TITLE','Titel');
define('LABEL_FIRST_NAME','Vorname');
define('LABEL_LAST_NAME','Nachname');
define('LABEL_COMPANY','Firma');
define('LABEL_BILLING_ADDRESS','Rechnungsadresse');
define('LABEL_TELEPHONE','Telefon');
define('LABEL_FAX','Fax');
define('LABEL_EMAIL','E-Mail Adresse');
define('LABEL_PASSWORD','Passwort');
define('LABEL_PASSWORDAGAIN','Passwort wiederholen');
define('LABEL_STREET','Straße');
define('LABEL_STREETNUMBER','Hausnr.');
define('LABEL_POSTCODE','Postleitzahl');
define('LABEL_CITY','Ort');
define('LABEL_COUNTRY','Land');

define('FIELDSET_GENERAL_INFORMATION','Allgemeine Daten');
define('FIELDSET_CONTACT_INFORMATION','Kontaktdaten');
define('FIELDSET_CUSTOMER_GENERAL_INFORMATION','Allgemeine Daten');
define('FIELDSET_CUSTOMER_CONTACT_INFORMATION','Kontaktdaten');
define('FIELDSET_CUSTOMER_ADDRESS_INFORMATION','Adressdaten');
define('FIELDSET_CUSTOMER_BILLING_ADDRESS_INFORMATION','Rechnungsadresse');

define('SELECT_CUSTOMER_GENDER_MALE','Herr');
define('SELECT_CUSTOMER_GENDER_FEMALE','Frau');
define('SELECT_GENDER_MALE','Herr');
define('SELECT_GENDER_FEMALE','Frau');

define('BUTTON_RESET','Zurücksetzen');

/* Contact form */
define('LEGEND_CONTACT_FORM','Kontaktformular');
define('RADIO_VALUE_QUESTION','Frage');
define('RADIO_VALUE_PROBLEM','Problem');
define('RADIO_VALUE_FEEDBACK','Feedback');
define('LABEL_YOUR_MESSAGE','Deine Nachricht');
define('LABEL_SEND','Senden');

/* Login process */
define('FIELDSET_LOGIN_FORM_CUSTOMER','Kundenanmeldung');
define('LINK_REGISTRATION','Registrieren');

/* shopping cart */
define('HEADING_PRODUCT','Produkt');
define('HEADING_QUANTITY','Menge');
define('HEADING_AMOUNT','Summe');

define('BUTTON_ADD_TO_CART', 'In den Einkaufswagen');
define('BUTTON_CREATE_ACCOUNT','Registrierung abschließen');
define('BUTTON_LOGIN_CUSTOMER','Einloggen');
define('BUTTON_LOGOUT_CUSTOMER','Abmelden');
define('BUTTON_EDIT_CUSTOMER','Meine Daten bearbeiten');
define('BUTTON_CHECKOUT','Kasse');
define('BUTTON_CHECKOUT_NEXT','Weiter');
define('IMG_TITEL_REMOVE', 'Entfernen');

/* message texts */
define('WARNING_SHORT_PASSWORD','Das angegebene Passwort ist zu kurz!');
define('WARNING_PASSWORD_NOT_MATCHING','Die eingegebenen Passwörter stimmen nicht überein!');
define('WARNING_INVALID_TELEPHONE','Bitte geben Sie eine gültige Telefonnummer ein!');
define('WARNING_INVALID_FAX','Bitte geben Sie eine gültige Faxnummer ein!');
define('WARNING_INVALID_EMAIL','Die eingegebene Email Adresse ist ungültig!');
define('WARNING_EMAIL_ALREADY_EXISTS','Es existiert schon ein Kunde mit der eingegebenen Email-Adresse!');
define('WARNING_FILL_ALL_MANDATORY_FIELDS','Bitte füllen Sie alle Pflichtfelder aus!');
define('WARNING_STILL_LOGGED_IN','Sie sind bereits angemeldet!');
define('WARNING_WRONG_CREDENTIALS','Die angegebenen Zugangsdaten sind nicht korrekt! Bitte prüfen Sie ihre Eingabe.');
define('WARNING_NOT_LOGGED_IN','Sie sind nicht angemeldet oder ihre Sitzung ist abgelaufen. Bitte melden Sie sich erneut an!');
define('WARNING_CONTENT_NOT_FOUND','Die angeforderte Seite wurde nicht gefunden!');
define('WARNING_SERVER_NO_SERVER_AVAILABLE','Für das Produkt %s steht aktuell leider kein passender Server zur Verfügung. Wir können Ihre Bestellung daher leider nicht erfüllen.');
define('WARNING_SERVER_NOT_ABLE_TO_ALLOCATE','Bei der Buchung des Produktes auf dem Server ist ein Fehler aufgetreten!');
define('WARNING_SERVER_NOT_ABLE_TO_FREE','Bei der Freigabe des Produktes auf dem Server ist ein Fehler aufgetreten!');
define('WARNING_CHECKOUT_PLEASE_ACCEPT_TERMS','Um Fortzufahren ist es nötig, dass Sie unsere allgemeinen Geschäftsbedingungen akzeptieren!');
define('WARNING_INVOICE_NOT_AUTHORIZED','Sie sind nicht berechtigt diese Rechnung zu öffnen!');
define('WARNING_DELETE_CONTRACT_CONFIRM','Wollen Sie den Vertrag wirklich kündigen?');
define('WARNING_REGISTRATION_RESET_FORM_CONFIRM','Wollen Sie wirklich alle Eingaben löschen?');
define('WARNING_INVALID_EMAIL_ADDRESS','Keine gültige E-Mail Adresse!');
define('WARNING_INVALID_PHONE_NO','Keine gültige Telefonnummer!');

define('SUCCESS_CONTRACT_TERMINATION','Das Produkt wurde erfolgreich zum %s gekündigt.');
define('SUCCESS_PRODUCT_TO_SHOPPINGCART', 'Das Produkt wurde erfolgreich in den Warenkorb gelegt.');

define('ERROR_SERVER_NOT_AVAILABLE','Für das Produkt %s ist kein Server verfügbar. Ein Kauf ist daher im Moment nicht möglich.');

/* product texts */
define('PRODUCT_QUANTITY', 'Menge');
define('PRODUCT_CONTRACT_PERIODE','Vertragslaufzeit');
define('PRODUCT_PRICE','Preis');
define('PRODUCT_DETAILS','Details');
define('PRODUCT_DETAILS_MORE','Mehr');
define('PRODUCT_DETAILS_LESS','Weniger');

/* main menu texts */
define('VIEW_MENU_HELP','Hilfe');
define('VIEW_MENU_CONTACT','Kontakt');
define('VIEW_MENU_IMPRINT', 'Impressum');
define('VIEW_MENU_HOME', 'Startseite');
define('VIEW_MENU_PRODUCTS', 'Produkte');
define('VIEW_MENU_CUSTOMERCENTER', 'Kundenbereich');
define('VIEW_MENU_SHOPPING_CART','Warenkorb');

/* customer center */
define('EXPLANATION_NUMBER_OF_INVOICES','Es liegen %d Rechnungen für Sie vor.');
define('TABLE_HEADING_INVOICE_INVOICE_NUMBER','Rechnungsnummer');
define('TABLE_HEADING_INVOICE_ISSUE_DATE','Datum');
define('TABLE_HEADING_INVOICE_AMOUNT','Betrag');
define('TABLE_HEADING_INVOICE_INVOICE_STATUS','Status');

define('EXPLANATION_NUMBER_OF_CONTRACTS','Aktuell haben Sie %d Verträge mit uns.');
define('TABLE_HEADING_CONTRACT_PRODUCT','Produkt');
define('TABLE_HEADING_CONTRACT_START_DATE','Anfangsdatum');
define('TABLE_HEADING_CONTRACT_EXPIRATION_DATE','Ablaufdatum');
define('TABLE_HEADING_CONTRACT_CONTRACT_PERIODE','Vertragslaufzeit');
define('TABLE_HEADING_CONTRACT_EXPIRATION_DATE_UNIT','Monat(e)');

define('LABEL_CONTRACT_TERMINATION_EXECUTION_DATE','zum %s gekündigt');

/* customer menu texts */
define('VIEW_CMENU_MYDATA', 'Meine Daten');
define('VIEW_CMENU_MYPRODUCTS', 'Meine Produkte');
define('VIEW_CMENU_MYINVOICES', 'Meine Rechnungen');

/* customer data view */
define('LABEL_LOGIN_DATA', 'Anmeldedaten');
define('LABEL_B_ADDRESS', 'Rechnungsanschrift');
define('LABEL_S_ADDRESS', 'Lieferanschrift');
define('LABEL_TEL', 'Tel.');
define('LABEL_SAME_ADRESS', 'Selbe Rechnungs- und Lieferanschrift');
define('BUTTON_CHANGE_PW', 'Passwort ändern');
define('MSG_CHANGES_SAVED', 'Ihre Daten wurden erfolgreich geändert!');

define('LINK_CANCEL_PRODUCT', 'Kündigen');

/* checkout process */
define('LABEL_ACCEPT_TERMS','Hiermit bestätige ich, dass ich die oben aufgeführten Geschäftsbedingungen gelesen und verstanden habe, sowie diese akzeptiere.');
define('HEADING_ORDER_OVERVIEW','Bestellübersicht');
define('BUTTON_CHECKOUT_SEND_ORDER','Bestellung abschicken');

/* communications */
define('NOTICE_COMMUNICATION_HTML_EMAIL','Um diese E-Mail korrekt darzustellen, verwenden Sie bitte ein HTML kompatibles E-Mail Programm!');
define('LABEL_COMMUNICATION_INVOICE_SUBJECT','Ihre Rechnung %s');
define('LABEL_COMMUNICATION_INVOICE_SUBJECT_ADMIN','Rechnung %s');

/* help / contact */
define('MSG_SUCCESSFULLY_SENT','Ihre Nachricht wurde erfolgreich an die Shopbetreiber gesendet!');
define('HEADING_SITEMAP', 'Sitemap');

/* invoice */
define('INVOICE_LABEL_INVOICE','Rechnung');
define('INVOICE_BANK_CONTACT','Bankverbindung');
define('INVOICE_NET_AMOUNT','Nettobetrag');
define('INVOICE_TAX_RATE','MwSt');
define('INVOICE_INVOICE_AMOUNT','Zahlbetrag');
define('INVOICE_CONTINUANCE','Fortsetzung der Rechnung auf der nächsten Seite.');
define('INVOICE_LABEL_POSITION','Pos');
define('INVOICE_LABEL_TOTAL','Gesamt');

/* -----------------------------  Backend   ------------------------------------------------ */

/* buttons */
define('BUTTON_LOGOUT_BACKEND','Abmelden');
define('BUTTON_LOGIN_BACKEND','Einloggen');
define('BUTTON_MODIFY_CUSTOMIZING_BACKEND','Customizing ändern');
define('BUTTON_SAVE_CUSTOMIZING_BACKEND','Customizing speichern');

define('BUTTON_CREATE_CONTENT','Neuen Inhalt erstellen');
define('BUTTON_CREATE_NEW_PRODUCT','Neues Produkt anlegen');
define('BUTTON_NEW_ATTR_FOR_PROD', 'Neues Attribut hinzufügen');
define('BUTTON_SAVE_ATTR_FOR_PROD', 'Attribut für Produkt anlegen');
define('BUTTON_CREATE_NEW_PRODUCT_ATTRIBUTE', 'Neues Produktattribut anlegen');
define('BUTTON_SAVE_CHANGES', 'Änderungen speichern');
define('IMG_REMOVE_PRODUCT', 'Produkt entfernen');
define('BUTTON_CREATE_PRODUCT_ATTRIBUTE', 'Attribut anlegen');
define('BUTTON_UPDATE_ADMIN_PASSWORD','administratives Passwort ändern');
define('BUTTON_CHANGE_SERVER', 'Server ändern');
define('BUTTON_CREATE_SERVER', 'Server anlegen');

define('MSG_BACKEND_WELCOME', 'Herzlich Willkommen im internen Bereich für den Shopbetreiber');
define('MSG_CUSTOMER_WELCOME', 'Herzlich Willkommen im Kundenbereich');

define('LINK_EDIT_PRODUCT', 'Bearbeiten');
define('LINK_TRANSLATE_PRODUCT', 'Übersetzen');
define('LINK_DEACTIVATE_PRODUCT', 'Deaktivieren');
define('LINK_ACTIVATE_PRODUCT', 'Aktivieren');

define('LINK_SAVE_INVOICE_STATUS', 'Statusänderung übernehmen');

define('LABEL_MY_SHOP','Mein Shop');
define('LABEL_MY_PRODUCTS','Meine Produkte');
define('LABEL_MY_PRODUCTATTRIBUTES', 'Meine Produktattribute');
define('LABEL_MY_SERVERS','Meine Server');
define('LABEL_MY_CUSTOMERS','Meine Kunden');
define('LABEL_MY_INVOICES','Meine Faktura');
define('LABEL_MY_CONTENT','Mein Inhalt');
define('LABEL_MY_STATISTICS','Meine Shopstatistiken');
define('LABEL_MY_PASSWORD','Mein Passwort ändern');

define('LABEL_PRODUCT_ID', 'Produkt Nr. ');
define('LABEL_PRODUCT_LANGUAGE', 'Sprache');
define('LABEL_PRODUCT_TITLE', 'Titel');
define('LABEL_PRODUCT_CONTRACT_PEROIDE', 'Vertragslaufzeit');
define('LABEL_PRODUCT_CONTRACT_PEROIDE_UNIT','Monat(e)');
define('LABEL_PRODUCT_DESCRIPTION', 'Beschreibung');
define('LABEL_PRODUCT_QUANTITY', 'Menge');
define('LABEL_PRODUCT_PRICE', 'Preis(€)');
define('LABEL_PRODUCT_PRICE_UNIT_EURO', '€');
define('LABEL_PRODUCT_DISCSPACE_UNIT','MB');

define('LABEL_PRODUCT_ATTRIBUTE', 'Attribute für Produkt Nr. ');
define('LABEL_PRODUCT_ATTRIBUTE_LANGUAGE', 'Sprache');
define('LABEL_PRODUCT_ATTRIBUTE_DESCRIPTION', 'Beschreibung');

define('LABEL_ATTRIBUTE', 'Attribut');
define('LABEL_VALUE', 'Wert ');

define('LABEL_SERVER_NAME','Servername');
define('LABEL_SERVER_MNGMNT_UI','Verwaltungsoberfläche');
define('LABEL_SERVER_IPV4','IPv4 Adresse');
define('LABEL_SERVER_IPV6','IPv6 Adresse');
define('LABEL_SERVER_TOTAL_SPACE','Speicherkapazität (gesamt)');
define('LABEL_SERVER_FREE_SPACE','Speicherkapazität (frei)');
define('LABEL_SERVER_AVAILABLE','Server aktiv im Verkaufspool');
define('LABEL_SERVER_FROXLOR_USERNAME','Froxlor Verwaltungsbenutzer');
define('LABEL_SERVER_FROXLOR_PASSWORD','Froxlor Passwort');
define('LABEL_SERVER_FROXLOR_DB','Froxlor Datenbank');
define('LABEL_SERVER_FROXLOR_DB_HOST','Froxlor Datenbankserver');

define('LABEL_PASSWORD_NEW_ADMIN_PASSWORD','Backendpasswort');

define('TABLE_HEADING_CONTENT_TITLE','Titel');
define('TABLE_HEADING_CUSTOMER_CUSTOMER_NUMBER','Kundennummer');
define('TABLE_HEADING_CUSTOMER_FIRST_NAME','Vorname');
define('TABLE_HEADING_CUSTOMER_LAST_NAME','Nachname');

define('TABLE_HEADING_PRODUCT_LANGUAGE', 'Sprache');
define('TABLE_HEADING_PRODUCT_TITLE', 'Titel');
define('TABLE_HEADING_PRODUCT_CONTRACT_PERIODE', 'Vertragslaufzeit');
define('TABLE_HEADING_PRODUCT_DESCRIPTION', 'Beschreibung');
define('TABLE_HEADING_PRODUCT_QUANTITY', 'Menge');
define('TABLE_HEADING_PRODUCT_PRICE', 'Preis');

define('TABLE_HEADING_SERVER_NAME', 'Servername');
define('TABLE_HEADING_SERVER_DISK_SPACE', 'Speicherplatz');
define('TABLE_HEADING_SERVER_STATUS','Status');

define('TABLE_HEADING_PRODUCT_ATTRIBUTE_LANGUAGE', 'Sprache');
define('TABLE_HEADING_PRODUCT_ATTRIBUTE_DESCRIPTION', 'Beschreibung');

define('FIELDSET_LOGIN_FORM_BACKEND','Anmeldung für administrativen Bereich');

define('FIELDSET_SERVER_SERVER_DATA','Server Informationen');
define('FIELDSET_SERVER_FROXLOR_DATA','Froxlor Informationen');

define('EXPLANATION_CUSTOMIZING_ENTRIES','Mit Hilfe der folgenden Einträge können Sie das Verhalten ihres Shops ganz einfach anpassen und bei eigenen Erweiterungen zusätzliche Einträge hinzufügen.');

define('EXPLANATION_NUMBER_OF_PRODUCTS','Aktuell stehen %d Produkte in Ihrer Sprache zum Verkauf zur Verfügung.');
define('EXPLANATION_NUMBER_OF_PRODUCT_ATTRIBUTES', 'Aktuell sind derzeit %d Produktattribute für Ihre Sprache im System eingepflegt.');

define('EXPLANATION_NUMBER_OF_CUSTOMERS','Aktuell haben Sie %d Kunden.');
define('EXPLANATION_NUMBER_OF_SERVERS','Aktuell befinden sich %d Server im Verkaufspool.');

define('EXPLANATION_CONTENT','Hier können Sie den Inhalt Ihrer Seiten verwalten.');

define('INFO_MESSAGE_PRODUCT_ATTRIBUTE_ALREADY_EXISTS', 'Dieses Produktattribut existiert bereits!');
define('INFO_MESSAGE_PRODUCT_ATTRIBUTE_UPDATE_SUCCESSFUL', 'Die Productattributänderungen wurden erfolgreich gespeichert.');
define('INFO_MESSAGE_PRODUCT_ATTRIBUTE_UPDATE_FAILED', 'Es ist ein Fehler beim Ändern des Datenbankeintrages aufgetreten');
define('INFO_MESSAGE_PRODUCT_ATTRIBUTE_CREATION_SUCCESSFUL', 'Produktattribut erfolgreich angelegt.');
define('INFO_MESSAGE_PRODUCT_ATTRIBUTE_CREATION_FAILED', 'Es ist ein Fehler beim Anlegen des Produktattributs aufgetreten.');

define('INFO_MESSAGE_PRODUCT_ATTRIBUTE_SUCCESSFULLY_DELETED', 'Produktattribut wurde erfolgreich entfernt.');
define('INFO_MESSAGE_PRODUCT_ATTRIBUTE_DELETION_FAILED', 'Es ist ein Fehler beim Löschen des Produktattributs aufgetreten.');

define('INFO_MESSAGE_PRODUCT_ATTRIBUTE_SUCCESSFULLY_TRANSLATED', 'Produktattribut wurde erfolgreich übersetzt.');
define('INFO_MESSAGE_PRODUCT_ATTRIBUTE_TRANSLATION_FAILED', 'Es ist ein Fehler beim Übersetzen des Produktattributs aufgetreten.');
define('INFO_MESSAGE_PRODUCT_ATTRIBUTE_TRANSLATIONS_FOR_ALL_SUPPORTED_LANGUAGES_ALREADY_EXIST', 'Für dieses Produktattribut existieren schon die Übersetzungen der unterstützten Sprachen.');

define('INFO_MESSAGE_PRODUCT_CREATION_SUCCESSFUL', 'Produkt wurde erfolgreich angelegt.');
define('INFO_MESSAGE_DB_ACTION_FAILED', 'Es ist ein Fehler beim Ändern der Datenbank aufgetreten.');

define('INFO_MESSAGE_PRODUCT_UPDATE_SUCCESSFUL', 'Die Produktänderungen wurden erfolgreich gespeichert.');
define('INFO_MESSAGE_PRODUCT_UPDATE_FAILED', 'Es ist ein Fehler beim Ändern des Datenbankeintrages aufgetreten');

define('INFO_MESSAGE_TRANSLATED_PRODUCT_ALREADY_EXISTS', 'Diese Übersetzung des Produkts %d existiert bereits!');
define('INFO_MESSAGE_TRANSLATION_SUCCEEDED', 'Produkt % d wurde erfolgreich übersetzt.');
define('INFO_MESSAGE_PRODUCT_ALREADY_EXISTS', 'Dieses Product existiert bereits!');

define('INFO_MESSAGE_PRODUCT_INFO_CREATION_SUCCESSFUL', 'Das Attribut wurde erfolgreich für das Produkt angelegt.');

define('WARNING_MESSAGE_SERVER_ALREADY_EXISTS', 'Es existiert bereits ein Server mit dieser IP-Adresse!');
define('ERROR_INVOICE_NOT_PAYED','Die Rechnung %d ist noch nicht bezahlt!');

define('INFO_MESSAGE_PRODUCT_STATE_CHANGE_SUCCESSFUL', 'Der Produktstatus wurde erfolgreich geändert.');
define('INFO_MESSAGE_PRODUCT_SUCCESSFULLY_DELETED', 'Das Produkt wurde erfolgreich gelöscht.');

define('INFO_MESSAGE_CUSTOMIZING_SAVED', 'Das Customizing wurde erfolgreich geändert.');

define('INFO_MESSAGE_CONTENT_UPDATED', 'Der Inhalt wurde erfolgreich geändert.');
define('INFO_MESSAGE_CONTENT_CREATED', 'Der Inhalt mit dem Titel wurde erfolgreich angelegt.');

define('INFO_MESSAGE_INVOICE_STATUS_CHANGED', 'Der Rechnungsstatus wurde erfolgreich geändert.');
define('INFO_MESSAGE_PRODUCT_INFO_SUCCESSFULLY_DELETED', 'Das Produktattribut wurde erfolgreich gelöscht.');

define('INFO_MESSAGE_SERVER_CREATION_SUCCESSFUL', 'Der Server wurde erfolgreich angelegt.');
define('INFO_MESSAGE_SERVER_UPDATE_SUCCESSFUL', 'Die Serveränderungen wurden erfolgreich gespeichert.');
define('INFO_MESSAGE_SERVER_SUCCESSFULLY_DELETED', 'Server wurde erfolgreich entfernt.');
define('INFO_MESSAGE_SERVER_DELETION_FAILED', 'Es ist ein Fehler beim Löschen des Servers aufgetreten.');

define('INFO_MESSAGE_PASSWORT_SUCCESSFULLY_CHANGED', 'Das Passwort wurde erfolgreich geändert!');
define('WARNING_MESSAGE_PASSWORT_CHANGE_ABORTED','Es ist ein Fehler beim Ändern des Passwortes aufgetreten. Versuchen Sie es später bitte erneut!');

?>

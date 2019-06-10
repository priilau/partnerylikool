<?php
namespace app\components;

class Identity {
	public $isGuest = true;
	public $authKey = "";
	public $user = null;

	/* AuthKey on sessioonis
	    Iga requestiga kontrollida, kas cookies ja sessionis on sama auth key. Kui cookies on midagi aga authkey ei klapi siis logoutida.
	    Kui cookies ei ole midagi, siis määrata, et on logged out.
	    Edukal sisselogimises gettida useri modeli andmed ja määrata Model object $this->user'isse. Määrata isGuest = false.

	Lisada funktsioon isLoggedIn, mis returnib vastavalt isGuest-i
	Lisada funktsioon random generateb auth stringi
	Lisada funktsioon mis validateb igal web requestil nt routeris või basecontrolleris, et kas sul auth key klapib
	    kui sessionis kirjas, et oled logged in. Ja kui ei klapi siis logged-outib.
	Lisada funktsioon logIn, mis võtab sisse omale user model objeti ja määrab selle külge
    */
}

?>
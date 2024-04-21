/*SCROLL TO TOP----------------------------------------------------------------------------------*/
// Po načítaní dokumentu sa pridá nasledujúci kód
document.addEventListener('DOMContentLoaded', function() {
    // Funkcia, ktorá posunie užívateľa na vrch stránky
    function scrollToTop() {
        window.scrollTo({
            top: 0, // Posunie sa na vrch stránky
            behavior: 'smooth' // Animácia posunu bude plynulá
        });
    }

    // Pridá sa poslucháč udalosti na posunutie okna
    window.addEventListener('scroll', function() {
        // Získa sa tlačidlo pre posun na vrch stránky
        var scrollButton = document.getElementById('scrollButton');
        // Ak sa užívateľ posunul viac ako 100 pixelov, tlačidlo sa zobrazí
        if (window.scrollY > 100) {
            scrollButton.style.display = 'block';
        } else { // Inak sa tlačidlo skryje
            scrollButton.style.display = 'none';
        }
    });

    // Získa sa tlačidlo pre posun na vrch stránky
    var scrollButton = document.getElementById('scrollButton');
    // Pridá sa poslucháč udalosti na kliknutie tlačidla, ktorý spustí funkciu pre posun na vrch stránky
    scrollButton.addEventListener('click', scrollToTop);
});
/*COOKIES----------------------------------------------------------------------------------*/
function acceptCookies() {
    document.getElementById('cookieConsent').style.display = 'none';
    // Nastaví sa cookie na zapamätanie si výberu užívateľa
}
/*POPUP----------------------------------------------------------------------------------*/
window.onload = function() {
    // Skontroluje sa, či užívateľ už súhlasil s používaním cookies
    // Ak nie, zobrazí sa vyskakovacie okno s upozornením na cookies
    document.getElementById('cookieConsent').style.display = 'block';
}
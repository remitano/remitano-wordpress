/* eslint-disable */
(function () {
  if (document.querySelectorAll) {
    function getApiUrl(sandbox) {
      var host;
      if (sandbox === "true") {
        host = "https://remidemo.com"
      } else {
        host = "https://remitano.com"
      }
      var baseUrl = host + "/btc";
      var apiUrl = baseUrl + "/payment_gateway/checkout";

      return apiUrl;
    }

    function handlePaymentButtonClick(element) {
      // Prevent double-click
      element.style.pointerEvents = "none"

      var url = getApiUrl(element.dataset["sandbox"]);
      url += "?merchant_username=" + element.dataset["merchantUsername"];
      url += "&coin_currency=" + element.dataset["coinCurrency"];
      url += "&coin_amount=" + element.dataset["coinAmount"];
      url += "&cancelled_or_completed_callback_url=" + element.dataset["cancelledOrCompletedCallbackUrl"];
      url += "&description=" + element.dataset["description"];

      window.location = url;
    }

    var paymentButtons = document.querySelectorAll('div.remitano-payment-btn');
    paymentButtons.forEach(function(element) {
      element.addEventListener("click", () => handlePaymentButtonClick(element));
    });
  }
})();

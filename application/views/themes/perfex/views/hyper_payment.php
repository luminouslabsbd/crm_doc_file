
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script src="https://beta.hyperswitch.io/v1/HyperLoader.js"></script>
<style>
    .hidden {
         display: none !important;
    }
    
    .hypers-sdk {
      width: 100%;
      margin-top: 50px;
    }
    
    .payNow {
      margin-top: 10px;
    }
    
    .Navbar {
      height: 7vh;
      display: flex;
      align-items: center;
      background: #ffffff;
      justify-content: center;
      box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.07);
    }
    
    .img {
      display: flex;
      flex-direction: row;
      justify-content: center;
      align-items: center;
      width: 30%;
      float: left;
    }
    
    .Item {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      height: auto;
      padding: 10px;
      border-bottom: 1px solid #f0eded;
    }
    
    .ItemTotal {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      height: auto;
      padding: 10px;
    }
    
    .ItemContainer {
      display: flex;
      flex-direction: row;
      width: 35%;
    }
    
    .itemDetails {
      padding: 8px;
    }
    
    .itemImg {
      width: auto;
    }
    
    .name {
      display: flex;
      font-style: normal;
      font-weight: 600;
      font-size: 16.3902px;
      padding-bottom: 10px;
      color: #212529;
    }
    
    .value {
      color: #212121;
    }
    
    .props {
      text-align: initial;
      display: flex;
      flex-direction: row;
      padding-bottom: 10px;
      color: #868E96;
      font-size: 15px;
    }
    
    .MenuItems {
      display: flex;
      flex-direction: row;
      justify-content: center;
      align-items: center;
      column-gap: 50px;
      height: auto;
      width: 40%;
    }
    
    .SDK {
      display: flex;
      margin: 4%;
      padding-bottom: 5%;
      justify-content: center;
      align-items: center;
    }
    
    .checkoutButton {
      height: 48px;
      border-radius: 25px;
      width: 100%;
      border: transparent;
      background: #006DF9;
      color: #ffffff;
      font-weight: 600;
      cursor: pointer
    }
    
    .ConfirmContainer {
      width: 100%;
      padding: 5%;
      margin-left: 20%;
      margin-right: 20%;
      margin-top: 2%;
      margin-bottom: 5%;
      display: flex;
      flex-direction: column;
      gap: 40px;
      justify-content: center;
    }
    
    .Cart {
      width: 100%;
      padding: 5%;
      margin-left: 5%;
      margin-right: 5%;
      display: flex;
      flex-direction: column;
      gap: 40px;
      justify-content: left;
    }
    
    .checkoutSection {
      display: flex;
      flex-direction: row;
      align-items: center;
    }
    
    .description {
      display: flex;
      flex-direction: column;
      width: 60%;
      text-align: left;
      padding: 3%;
      font-style: normal;
      font-weight: 400;
      font-size: 16px;
      color: #212121;
    }
    
    .subtext {
      padding-top: 3%;
      color: rgba(33, 33, 33, 0.5);
      font-weight: 400;
      font-size: 18px;
      line-height: 24px;
    }
    
    .here {
      color:
        #006DF9;
    }
    
    .spinner,
    .spinner:before,
    .spinner:after {
      border-radius: 50%;
    }
    
    .spinner {
      color: #ffffff;
      font-size: 22px;
      text-indent: -99999px;
      margin: 0px auto;
      position: relative;
      width: 20px;
      height: 20px;
      box-shadow: inset 0 0 0 2px;
      -webkit-transform: translateZ(0);
      -ms-transform: translateZ(0);
      transform: translateZ(0);
    }
    
    .spinner:before,
    .spinner:after {
      position: absolute;
      content: '';
    }
    
    @keyframes loading {
      0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
      }
    
      100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
      }
    }
    
    .spinner:before {
      width: 10.4px;
      height: 20.4px;
      background: #016df9;
      border-radius: 20.4px 0 0 20.4px;
      top: -0.2px;
      left: -0.2px;
      -webkit-transform-origin: 10.4px 10.2px;
      transform-origin: 10.4px 10.2px;
      -webkit-animation: loading 2s infinite ease 1.5s;
      animation: loading 2s infinite ease 1.5s;
    }
    
    #payment-message {
      font-size: 16px;
      font-weight: 400;
      padding: 2%;
      color: #ff0000;
    }
    
    .spinner:after {
      width: 10.4px;
      height: 10.2px;
      background: #016df9;
      border-radius: 0 10.2px 10.2px 0;
      top: -0.1px;
      left: 10.2px;
      -webkit-transform-origin: 0px 10.2px;
      transform-origin: 0px 10.2px;
      -webkit-animation: loading 2s infinite ease;
      animation: loading 2s infinite ease;
    }
    
    .CheckoutButton {
      color: #ffffff;
      width: 362px;
      background: #006DF9;
      padding: 16px 8px;
      font-weight: 600;
      font-size: 17px;
      border-radius: 64px;
      border: transparent;
      cursor: pointer;
    }
    
    .total {
      font-weight: 400;
      font-size: 16px;
      color: #000000;
      opacity: 0.9;
    }
    
    .buttonSection {
      padding: 3%;
      margin-right: 3%;
      width: 70%;
      justify-content: flex-end;
      display: flex;
    }
    
    .orderSummary {
      font-style: normal;
      font-weight: 600;
      font-size: 20px;
      text-align: initial;
    }
    
    .items {
      display: flex;
      width: 100%;
      flex-direction: column;
    }
    
    .elements {
      display: flex;
      flex-direction: column;
      width: 100%;
    }
    
    #payment-form {
      max-width: 560px;
      width: 100%;
      margin: 0 auto;
      text-align: center;
    }
    
    .cartItems {
      height: auto;
      background: #ffffff;
      box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.09);
      border-radius: 8px;
    }
    
    .Workspace {
      height: 86vh;
      display: flex;
      flex-direction: row;
    }
    
    .confirmBox {
      display: flex;
      flex-direction: column;
      justify-content: center;
      gap: 40px;
      align-items: center;
      height: 100%;
      background: #ffffff;
      box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.09);
      border-radius: 8px;
    }
    
    .returnLink {
      font-weight: 400;
      font-size: 16px;
      color: #4285F4;
    }
    
    .ConfirmText {
      font-weight: 700;
      font-size: 26px;
      color: #000000;
    }
    
    .ConfirmDes {
      width: 100%;
      font-weight: 400;
      font-size: 16px;
      color: #000000;
      opacity: 0.4;
    }
    
    .bodyContainer {
      display: flex;
      justify-content: center;
      background: #FFFFFF;
      align-items: flex-start;
      height: 80%;
      width: 100%;
      box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.07);
      border-radius: 6.47171px;
      margin-top: 10%;
      margin-bottom: 5%;
      overflow-y: scroll;
    }
    
    .containerText {
      width: 100%;
      display: flex;
      padding-top: 5%;
    }
    
    .paymentDescription {
      height: 100%;
      width: 100%;
      padding: 1%;
    }
    
    .textbox {
      display: flex;
      background: rgba(187, 187, 187, 0.08);
      /* height: 100px; */
      padding: 5%;
      margin: 2%;
      border-radius: 8px;
      text-align: left;
      font-weight: 200;
    }
    
    .listItem {
      padding: 1%;
      padding-top: 0%;
    }
    
    .Container {
      height: 86vh;
      overflow-y: scroll;
      gap: 1%;
      display: flex;
      flex-direction: row;
      padding-left: 10%;
      padding-right: 10%;
    }
    
    .body1 {
      display: flex;
      margin: 1em;
      width: 50%;
    }
    
    .body2 {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin: 1em;
      width: 50%;
    }
    
    .bodyContainer2 {
      color: #212121;
      font-size: 16px;
      font-weight: 600;
      display: flex;
      flex-direction: column;
      align-items: center;
      background: #FFFFFF;
      height: 80%;
      width: 100%;
      box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.07);
      border-radius: 6.47171px;
      margin-top: 10%;
      margin-bottom: 5%;
      overflow-y: scroll;
    }
    
    .Blogs {
      display: flex;
      flex-direction: row;
      column-gap: 1em;
      width: 50%;
      justify-content: center;
      align-items: center;
    }
    
    .Contact {
      width: 50%;
      cursor: pointer;
    }
    
    .Footerlink {
      cursor: pointer;
      color: #CDECFF;
      overflow-wrap: break-word;
    }
    
    .Menulink {
      cursor: pointer;
      font-size: 16px;
      font-weight: 400;
      color: #151A1F;
      text-decoration: none;
    }
    
    .earlyAccess {
      color: #006DF9;
      text-decoration: none;
      cursor: pointer;
    }
    
    .GetEarlyAccess {
      width: 10%;
    }
    
    .select {
      display: flex;
      flex-direction: row;
      column-gap: 5px;
      justify-content: center;
      align-items: center;
      width: 180px;
      height: 30px;
      border-radius: 25px;
      color: #212121;
      border: 1px solid #D6D9E0;
    }
    
    .countrySelect {
      outline: none;
      background: transparent;
      border: transparent;
    }
    
    .Footer {
      display: flex;
      color: #CDECFF;
      justify-content: center;
      align-items: center;
      background: #152B45;
      height: 7vh;
    }
    
    @media only screen and (max-width: 1200px) {
      .ConfirmDes {
        width: 100%;
      }
    
      .Container {
        display: flex;
        flex-direction: column-reverse;
        justify-content: center;
        align-items: center;
        min-height: 86vh;
        height: auto;
        overflow-y: scroll;
        gap: 1%;
        overflow-x: hidden;
      }
    
      .Footer {
        padding: 2%;
        height: fit-content;
        flex-direction: column;
        gap: 30px;
      }
    
      .checkoutButton {
        width: 95%;
      }
    
      .body1 {
        width: 100%;
        overflow-y: hidden;
      }
    
      .body2 {
        width: 100%
      }
    
      .img {
        justify-content: flex-start;
      }
    
      .Menulink {
        display: none;
      }
    
      .GetEarlyAccess {
        width: 102%;
        display: none;
      }
    
      .Navbar {
        padding-left: 10px;
        padding-right: 10px;
      }
    
      .checkoutSection {
        flex-direction: column-reverse;
        width: 100%;
      }
    
      .buttonSection {
        width: 100%;
        justify-content: center;
      }
    
      .description {
        width: 100%;
        text-align: center;
      }
    }

</style>

<div class="panel_s">
	
    <body>
        <div class="hypers-sdk" id="hypers-sdk">
            <form id="payment-form" onsubmit="handleSubmit(); return false;">
              <div id="unified-checkout">
                <!--HyperLoader injects the Unified Checkout-->
              </div>
              <button id="submit" class="checkoutButton payNow">
                <div class="spinner hidden" id="spinner"></div>
                <span id="button-text">Pay now</span>
              </button>
              <div id="payment-message" class="hidden"></div>
            </form>
        </div>


          <div class="ConfirmContainer hidden" id="orderSuccess">
            <div><img width="150px" height="110px"
                src="https://demo-hyperswitch.netlify.app/static/media/Successsuccess.5789e33b69b916d8485c1e6de79d60fa.svg">
            </div>
            <div class="ConfirmText">Thanks for your order!</div>
            <div class="ConfirmDes">Yayyy! You successfully made a payment with Hyperswitch. If its a real store, your items
              would have been on their way.</div>
            <div><a class="returnLink" href="" onClick="retryPayment()">Try hyperswitch Demo again</a></div>
          </div>

        <div class="Container hidden">
            <div class="Cart">
            <div class="orderSummary">Order summary (2)</div>
            <div class="items">
                <div class="Item">
                <div class="ItemContainer">
                    <div class="itemImg"><img width="100" height="100"
                        src="https://cdn.pixabay.com/photo/2016/12/06/09/31/blank-1886008_1280.png">
                    </div>
                    <div class="itemDetails">
                    <div class="name">HS Tshirt</div>
                    <div class="props">Size: <span class="value">37 &nbsp;&nbsp;&nbsp;</span>Qty:<span class="value">1 </span>
                    </div>
                    <div class="props">Color: <span class="value">Black</span></div>
                    </div>
                </div>
                <div> 100.00</div>
                </div>
                <div class="Item">
                <div class="ItemContainer">
                    <div class="itemImg"><img width="100" height="100"
                        src="https://cdn.pixabay.com/photo/2016/12/06/09/31/blank-1886008_1280.png">
                    </div>
                    <div class="itemDetails">
                    <div class="name">HS Cap</div>
                    <div class="props">Size: <span class="value">2 &nbsp;&nbsp;&nbsp;</span>Qty:<span class="value">1 </span>
                    </div>
                    <div class="props">Color: <span class="value">Black</span></div>
                    </div>
                </div>
                <div> 100.00</div>
                </div>
                <div class="ItemTotal">
                <div class="total">Total Amount</div>
                <div> 200.00</div>
                </div>
            </div>
            
                <div class="checkoutSection">
            
                <div onClick="showSDK()" class="buttonSection"><button class="CheckoutButton">Pay</button>
    
                </div>
            </div>
            </div>
        </div>
    </body>
    
    <!--hyper_payment/update_invoice_status-->
    <form method="post" class="update_invoice_status" action=""> 
    
        <input type="hidden" name="payment_id" id="payment_id">
        <input type="hidden" name="status" id="payment_status">
        <input type="hidden" name="merchant_id" id="merchant_id">
        <input type="hidden" name="client_secret" id="client_secret">
        
    </form>
    
    <!--Payment Script -->
    
    <script>

    const api_publishable_key = "<?php echo $hyperswitch_api_secret_key ?>"
   
    const hyper = Hyper(api_publishable_key);
    
    const items = [{ 
        id: "xl-tshirt" 
    }];

    async function initialize() {

    const { client_secret } = await fetch("/api-reques-to-getway", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ items }),
    }).then((r) => r.json());

    // You can change the apperance of the SDK by adding field here
    const appearance = {
        // theme: "midnight",
    };

    widgets = hyper.widgets({
        appearance,
        clientSecret: client_secret
    });

    const unifiedCheckoutOptions = {
        layout: "tabs",
        wallets: {
        walletReturnUrl: "http://perfex-crm.keoscx.com/payment-complete",
        //Mandatory parameter for Wallet Flows such as Googlepay, Paypal and Applepay
        },
    };

    const unifiedCheckout = widgets.create("payment", unifiedCheckoutOptions);
    unifiedCheckout.mount("#unified-checkout");
    }
    initialize();

    async function handleSubmit(e) {
    setLoading(true);
    const { error, data, status } = await hyper.confirmPayment({
        widgets,
        confirmParams: {
        // Make sure to change this to your payment completion page
        return_url: "http://perfex-crm.keoscx.com/payment-complete",
        },
    });

    // This point will only be reached if there is an immediate error occurring while confirming the payment. Otherwise, your customer will be redirected to your `return_url`.

    // For some payment flows such as Sofort, iDEAL, your customer will be redirected to an intermediate page to complete authorization of the payment, and then redirected to the `return_url`.

    if (error && error.type === "validation_error") {
        showMessage(error.message);
    }
    else if (status === "succeeded") {
        
        // payment_id ,merchant_id,client_secret
        // let pay_id = document.getElementById('payment_id');
        // let pay_status = document.getElementById('payment_status');
        // let merchant = document.getElementById('merchant_id');
        // let client_secret_id = document.getElementById('client_secret');
        // pay_id.value = payment_id;
        // pay_status.value = status;
        // merchant.value = merchant_id;
        // client_secret_id.value = client_secret;
        // $('.status').trigger('submit');
        
        // addClass("#hypers-sdk", "hidden")
        // removeClass("#orderSuccess", "hidden")
        
    }
    else {
        showMessage("An unexpected error occurred.");
    }

    setLoading(false);
    }

    // Fetches the payment status after payment submission
    async function checkStatus() {
    const clientSecret = new URLSearchParams(window.location.search).get(
        "payment_intent_client_secret"
    );

    if (!clientSecret) {
        return;
    }

    const { payment } = await hyper.retrievePayment(clientSecret);

    switch (payment.status) {
        case "succeeded":
        showMessage("Payment succeeded!");
        break;
        case "processing":
        showMessage("Your payment is processing.");
        break;
        case "requires_payment_method":
        showMessage("Your payment was not successful, please try again.");
        break;
        default:
        showMessage("Something went wrong.");
        break;
    }
    }

    function setLoading(showLoader) {
    if (showLoader) {
        show('.spinner');
        hide('#button-text');
    }
    else {
        hide('.spinner');
        show('#button-text');
    }
    }

    function show(id) {
        removeClass(id, 'hidden');
    }
    function hide(id) {
        addClass(id, 'hidden');
    }

    function showMessage(msg) {
    show('#payment-message');
    addText('#payment-message', msg);
    }

    function addText(id, msg) {
    var element = document.querySelector(id);
    element.innerText = msg;
    }

    function addClass(id, className) {
    var element = document.querySelector(id);
    element.classList.add(className);
    }

    function removeClass(id, className) {
    var element = document.querySelector(id);
    element.classList.remove(className);
    }

    function retryPayment() {
        hide('#orderSuccess');
        // show('.Container');
        hide('.Container');
        // show('#hypers-sdk');
        initialize();
    }

    function showSDK(e) {
        hide('.Container');
        show('#hypers-sdk');
    };

</script>

</div>

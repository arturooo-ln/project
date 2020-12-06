<div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><b>Zapłać za swoje zamówienie</b></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <label for="cardName" class="checkout-form">Imię Nazwisko</label>
                        <input type="text" class="form-control" value="" name="cardName" id="cardName" placeholder="Jan kowalski" required>

                        <label for="cardNumber" class="checkout-form">Numer karty</label>
                        <input type="number" class="form-control" value="" name="cardNumber" id="cardNumber" placeholder="1234 5678 9012 3456" pattern=".{16}" required>
                        <div class="row">
                            <div class="col-xs-5">
                                <label for="cardDate" class="checkout-form">Data ważności karty</label>
                                <input type="text" class="form-control" value="" name="cardDate" id="cardDate" placeholder="12/19" required>
                            </div>
                            <div class="col-xs-2">
                                <label for="cardCode" class="checkout-form">CVC</label>
                                <input type="password" class="form-control" value="" name="cardCode" id="cardCode" placeholder="***" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group form-check" required>
                                <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                                <label class="form-check-label" for="exampleCheck1">Postanowienia zawarte w „Regulaminie kart płatniczych dla Klientów indywidualnych w PKO Banku Polskim SA”, zwanym dotychczas „Regulaminem kartpłatniczych dla Klientów indywidualnych Nordea Bank Polska S.A.”, określają zasady wydawania i używania kart płatniczych przeznaczonych dla klientów indywidualnych PKO Banku Polskiego SA w zakresie: 1 kart debetowych: Visa Electron Adm. oraz Visa Instant Adm., 2 kart kredytowych: Karta kredytowa Adm., Karta kredytowa MasterCard Platinum Adm., Karta kredytowa Visa Classic PayWave Adm., Karta kredytowa Visa Gold PayWave Adm., Karta kredytowa MasterCard Aspiracje Standard Adm., Karta kredytowa MasterCard Aspiracje Gold Adm., 3 kart obciążeniowych: Visa Classic Adm. oraz Visa Gold Adm. </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="checkout_btn"" value=" Potwierdź" name="checkout">
                    </div>
                </div>

            </div>
        </div>
<div id="page-wrapper">
    <div id="error">
        <script src='https://www.google.com/recaptcha/api.js' async defer ></script>

    </div>
    <h3>Aanmelden</h3>
    <form id="loginform" name="inloggen" class="form" method="POST" >
        <input class="input" type="text"     required name="voornaam"   placeholder="Voornaam" /><br>
        <input class="input" type="email"    required name="email"      placeholder="E-mail" /><br>
        <input class="input" type="password" required name="password"   placeholder="Password" /><br><br>

        <!-- Voeg captcha toe in een div -->
        <!-- <center><div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI" data-theme="dark"></div><center/> -->

        <center><div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></center>

        <br/>
        <input type="hidden"  name="submit" value="true" />
        <input type="submit" id="submit" value=" Aanmelden " />

    </form>
</div>

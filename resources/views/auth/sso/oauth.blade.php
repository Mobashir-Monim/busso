<input type="hidden" name="stuff" value="{{ $oauth }}" id="stuff">

<script>
    window.onload = () => {
        console.log('{{ (new App\Helpers\SSOHelpers\OAuth\LoginOauthLogin)->authenticatorParamDecompressor($oauth) }}');
    }
</script>
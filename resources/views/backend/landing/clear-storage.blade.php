<script>
    setTimeout(function(){
        let html    = `{{  (isset($landing) ? $landing->html_content : '')  }}`;
        console.log(html);
        //localStorage.setItem("gjs-css", `{{  (isset($landing) ? $landing->css_content : '')  }}`);
        //localStorage.setItem("gjs-html", html);
        //localStorage.setItem("gjs-styles", null);

        localStorage.setItem('storage_removed', "0");

        window.location.replace("{{ url('backend/landing/builder/' . (isset($landing) ? $landing->id : '') . '?storage=clear') }}");
        return false;
    },1000);
</script>

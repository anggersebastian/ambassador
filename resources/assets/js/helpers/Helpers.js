import Vue from 'vue'

Vue.prototype.$formatCurrency =  (value) => {
    let params = parseFloat(value)
    let genAngka = params.toFixed(2)
    genAngka = genAngka.split('.')
    if(genAngka.length > 1){
        params = genAngka[0]
    }
    let reverse = params.toString().split('').reverse().join('')
    let ribuan = reverse.match(/\d{1,3}/g)
    if(ribuan == null){
        return ribuan = 0   
    }
    ribuan = ribuan.join('.').split('').reverse().join('')
    return ribuan
}

Vue.prototype.$readMore = (value) => {
    let returns = {
        first : '',
        more : ''
    }

    let cut = value.split(' ')
      
    if(cut.length > 2){
        cut.forEach((x, index) => {
            if(index <= 2){
                return returns.first += x+' '
            } else {
                return returns.more += x+' '
            }
        })
    } else{
        returns.first = value
    }

    return returns
}

Vue.prototype.$cekNumber = (evt) => {
    evt = (evt) ? evt : window.event;
    if(evt.key == '.') return true
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        evt.preventDefault();
    } else {
        return true;
    }
}
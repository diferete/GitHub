/* 
 * Arquivo que contêm validações adicionais de tipos de campos
 */

Ext.apply(Ext.form.VTypes,{
    cpf: function(val,field){
        if (val!='' && val!='___.___.___-__') {
            if((val = val.replace(/[^\d]/g,"").split("")).length != 11) return false;
            if(new RegExp("^" + val[0] + "{11}$").exec(val.join(""))) return false;
            for(var s = 10, n = 0, i = 0; s >= 2; n += val[i++] * s--);
                if(val[9] != (((n %= 11) < 2) ? 0 : 11 - n)) return false;
            for(var s = 11, n = 0, i = 0; s >= 2; n += val[i++] * s--);
                if(val[10] != (((n %= 11) < 2) ? 0 : 11 - n)) return false;
            return true;
        } else {
            return true;
        }
    },
    cpfText: 'CPF informado é inválido!',
    cpfMask: /[0-9]/i
});

Ext.apply(Ext.form.VTypes,{
    cnpj: function(val,field){
        if (val != '' && val!='__.___.___/____-__') {
            exp = /\.|\-|\//g
            var val = val.toString().replace( exp, "" ); 
            var b = [6,5,4,3,2,9,8,7,6,5,4,3,2];
            if((val = val.replace(/[^\d]/g,"").split("")).length != 14) return false;
            for(var i = 0, n = 0; i < 12; n += val[i] * b[++i]);
                if(val[12] != (((n %= 11) < 2) ? 0 : 11 - n)) return false;
            for(var i = 0, n = 0; i <= 12; n += val[i] * b[i++]);
                if(val[13] != (((n %= 11) < 2) ? 0 : 11 - n)) return false;
            return true;
        } else {
            return true;
        }
    },
    cnpjText: 'CNPJ informado é inválido!',
    cnpjMask: /[0-9]/i
});


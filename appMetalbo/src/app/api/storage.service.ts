import { Injectable } from '@angular/core';
import { Storage } from '@ionic/storage';

@Injectable({
  providedIn: 'root'
})
export class StorageService {

    constructor(public storage: Storage) { }
   

    gravaDados(usucodigo, usunome, usologin, codsetor, usutoken, usuemail) {
        
        this.storage.remove('usutoken');

        this.storage.set('usucodigo', usucodigo);
        this.storage.set('usunome', usunome);
        this.storage.set('usologin', usologin);
        this.storage.set('codsetor', codsetor);
        this.storage.set('usutoken', usutoken);
        this.storage.set('usuemail', usuemail);

    }

    removeDados() {
        this.storage.clear();
    }

   

    retornaToken() {
        
        let token: any;
        return new Promise((resolve, reject)=> {
            //busca dados do usuário no storage
            
            this.storage.get('usutoken').then(result => {
                
                if (result != null) {

                    token = result;

                    resolve(token);
                } else {
                   // alert('chegou');
                }
            }).catch(e => {
                console.log('error: ' + e);
                resolve('fxI3CdxbD3S4nQdOXSq4WOu3N');
            });
        });
     }

    retornaUsuCod() {
        
        let usucod: any;
          return new Promise((resolve, reject) => {
              this.storage.get('usucodigo').then(result => {
                  if (result != null) {
                      usucod = result;
                      resolve(usucod);
                  }
              }).catch(e => {
                  console.log('error: ' + e);
                  resolve('344');
              });
          });
         
    }
}

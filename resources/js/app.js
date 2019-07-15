
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('vue2-datepicker', require('./components/DatePicker.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

if (document.querySelector('#app1')) {
    const app1 = new Vue({
        el: '#app1'
    });
}

if (document.querySelector('#orase-ore-plecare')) {
    const app2 = new Vue({
        el: '#orase-ore-plecare',
        data: {
            oras_plecare: orasPlecareVechi,
            orase_plecare: '',
            statie_id: statieImbarcareVeche,
            statii_imbarcare: '',
            oras_sosire: orasSosireVechi,
            orase_sosire: '',
            ora_plecare: oraPlecareVeche,
            ore_plecare: '',
            ora_sosire: '',
            retur_ora_plecare: returOraPlecareVeche,
            retur_ore_plecare: '',
            retur_ora_sosire: '',
            // numarul de adulti si copii
            nr_adulti: nrAdultiVechi,
            nr_copii: nrCopiiVechi,
            // preturile per adult si per copil pentru curse            
            pret_adult: 0,
            pret_copil: 0,
            pret_total: pretTotal,

            retur: false,

            plata_online: plataOnlineVeche,
            // plata_online: false
        },
        created: function () {
            this.getOrasePlecareInitial()
            this.getOraseSosireInitial()
            this.getOrePlecareInitial()
            this.getOraSosireInitial()
            this.getReturOrePlecare()
        },
        methods: {
            getOrasePlecareInitial: function () {
                axios.get('/orase_ore_rezervari', {
                    params: {
                        request: 'orase_plecare',
                    }
                })
                    .then(function (response) {
                        app2.orase_plecare = response.data.raspuns;
                    });
            },
            getOrasePlecare: function () {
                axios.get('/orase_ore_rezervari', {
                    params: {
                        request: 'orase_plecare',
                    }
                })
                    // .then(function (response) {
                    //     app2.orase_plecare = response.data;
                    .then(function (response) {
                        app2.orase_plecare = response.data.raspuns;
                        // app2.pret_adult = pret_adult.data;

                        // app2.orase_sosire = '';
                        // app2.oras_sosire = 0;
                        // app2.ore_plecare = '';
                        // app2.ora_plecare = 0;
                    });
            },
            getOraseSosireInitial: function () {
                axios.get('/orase_ore_rezervari', {
                    params: {
                        request: 'orase_sosire',
                        oras_plecare: this.oras_plecare,
                    }
                })
                    .then(function (response) {
                        app2.orase_sosire = response.data.raspuns;
                        app2.statii_imbarcare = response.data.statii_imbarcare;
                    });
            },
            getOraseSosire: function () {
                axios.get('/orase_ore_rezervari', {
                    params: {
                        request: 'orase_sosire',
                        oras_plecare: this.oras_plecare,
                    }
                })
                    .then(function (response) {
                        app2.statii_imbarcare = '',
                        app2.statie_id = 0,
                        app2.orase_sosire = '';
                        app2.oras_sosire = 0;
                        app2.ore_plecare = '';
                        // app2.ora_plecare = 0;
                        app2.ora_sosire = '';
                        app2.pret_adult = 0;
                        app2.pret_copil = 0;

                        app2.orase_sosire = response.data.raspuns;
                        app2.statii_imbarcare = response.data.statii_imbarcare;
                        app2.getPretTotal();
                    });
                // app2.getPretTotal();
            },
            getOrePlecareInitial: function () {
                axios.get('/orase_ore_rezervari', {
                    params: {
                        request: 'ore_plecare',
                        oras_plecare: this.oras_plecare,
                        oras_sosire: this.oras_sosire,
                    }
                })
                    .then(function (response) {
                        app2.ore_plecare = response.data.raspuns;
                        app2.pret_adult = response.data.pret_adult;
                        app2.pret_copil = response.data.pret_copil;
                        // app2.getPretTotal();
                    });
            },
            getOrePlecare: function () {
                axios.get('/orase_ore_rezervari', {
                    params: {
                        request: 'ore_plecare',
                        oras_plecare: this.oras_plecare,
                        oras_sosire: this.oras_sosire,
                    }
                })
                    .then(function (response) {
                        app2.ore_plecare = '';
                        // app2.ora_plecare = 0;
                        app2.ora_sosire = '';

                        app2.ore_plecare = response.data.raspuns;
                        app2.pret_adult = response.data.pret_adult;
                        app2.pret_copil = response.data.pret_copil;
                        // Vue.set(app2.pret_adult);
                        // Vue.set(app2.pret_copil = response.data.pret_copil);
                        app2.getPretTotal();
                    });
                // app2.getPretTotal();
            },
            getOraSosireInitial: function () {
                axios.get('/orase_ore_rezervari', {
                    params: {
                        request: 'ora_sosire',
                        oras_plecare: this.oras_plecare,
                        oras_sosire: this.oras_sosire,
                        ora_plecare: this.ora_plecare,
                    }
                })
                    .then(function (response) {
                        app2.ora_sosire = response.data.raspuns;
                    });
            },
            getOraSosire: function () {
                axios.get('/orase_ore_rezervari', {
                    params: {
                        request: 'ora_sosire',
                        oras_plecare: this.oras_plecare,
                        oras_sosire: this.oras_sosire,
                        ora_plecare: this.ora_plecare,
                    }
                })
                    .then(function (response) {
                        app2.ora_sosire = response.data.raspuns;
                    });
            },
            getPretTotal (){
                this.pret_total = 0;
                if (!isNaN(this.nr_adulti) && (this.nr_adulti > 0)) {
                    this.pret_total = this.pret_total + this.pret_adult * this.nr_adulti
                }
                if (!isNaN(this.nr_copii) && (this.nr_copii > 0)) {
                    this.pret_total = this.pret_total + this.pret_copil * this.nr_copii
                }
            },
            getReturOrePlecare: function () {
                axios.get('/orase_ore_rezervari', {
                    params: {
                        request: 'retur_ore_plecare',
                        oras_plecare: this.oras_plecare,
                        oras_sosire: this.oras_sosire,
                    }
                })
                    .then(function (response) {
                        app2.retur_ore_plecare = '';
                        // app2.retur_ora_plecare = 0;
                        app2.retur_ora_sosire = '';

                        app2.retur_ore_plecare = response.data.raspuns;
                    });
            },
            getReturOraSosire: function () {
                axios.get('/orase_ore_rezervari', {
                    params: {
                        request: 'retur_ora_sosire',
                        oras_plecare: this.oras_plecare,
                        oras_sosire: this.oras_sosire,
                        retur_ora_plecare: this.retur_ora_plecare,
                    }
                })
                    .then(function (response) {
                        app2.retur_ora_sosire = response.data.raspuns;
                    });
            },
            plata_integrala() {
                this.comision_agentie = this.pret_total;
            },
        }
    });
};


if (document.querySelector('#rezervari-raport-zi')) {
    const app3 = new Vue({
        el: '#rezervari-raport-zi',
        data: {
            search_oras: searchOrasVechi,
            orase_plecare: '',
            search_ora: searchOraVeche,
            ore_plecare: ''
        },
        created: function () {
            this.getOrasePlecareInitial()
            this.getOrePlecare()
        },
        methods: {
            getOrasePlecareInitial: function () {
                axios.get('/orase_ore_zi_rezervari', {
                    params: {
                        request: 'orase_plecare',
                    }
                })
                    .then(function (response) {
                        app3.orase_plecare = response.data.raspuns;
                    });
            },
            getOrePlecare: function () {
                axios.get('/orase_ore_zi_rezervari', {
                    params: {
                        request: 'ore',
                        search_oras: this.search_oras,
                    }
                })
                    .then(function (response) {
                        app3.ore_plecare = '';

                        app3.ore_plecare = response.data.raspuns;
                    });
            },
        },
    });
};

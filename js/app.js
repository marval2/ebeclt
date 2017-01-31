/**
 * Created by marval2 on 2017-01-29.
 */

(function(){
    new Vue({
        el: '#registration',
        data: {
            message: 'Hello Vue.js!',
            currentView: "page2"
        },
        components: {
            mainPage: {template: "<h3>Pagrindinis tekstas</h3>"},
            page1: {template: "<h3>Šiaip tekstas</h3>"},
            page2: {template: "<h3>Dar tekstas2</h3>"}
        },
        methods: {
            switchComponent: function (compName) {
                console.log(compName);
                this.currentView = compName;
            },
            say: function (message) {
                alert(message)
            }
        }
    })
})();
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <v-alert type="success">
                        I'm a success alert.
                    </v-alert>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Echo from "laravel-echo";
export default {
    name: "MainAppComponent",
    data() {
        return {
            echo: ""
        };
    },
    methods: {
        pusherLister: function() {
            window.Echo.channel("my-channel")
                .listen("my-event", data => {
                    console.log('ok');
                });
        }
    },

     created() {
  
       this.pusherLister();
    }
};
</script>

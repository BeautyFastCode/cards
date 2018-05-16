<template>
    <div>
        <h1>Suites</h1>
        <hr>

        <ul v-if="suites && suites.length">
            <li v-for="suite of suites">
                <p><strong>{{suite.name}}</strong></p>
            </li>
        </ul>

        <ul v-if="errors && errors.length">
            <li v-for="error of errors">
                {{error.message}}
            </li>
        </ul>

        <hr>
    </div>
</template>

<script>
    import {HTTP} from '../Http/http-common';

    export default {
        data() {
            return {
                suites: [],
                errors: []
            }
        },

        /**
         * Fetches suites when the component is created.
         */
        created() {
            HTTP.get(`suites`)
                    .then(response => {

                        // JSON responses are automatically parsed.
                        this.suites = response.data
                    })
                    .catch(e => {
                        this.errors.push(e)
                    });
        }
    }
</script>

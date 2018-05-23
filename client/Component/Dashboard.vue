<template>
    <div class="dashboard">
        <template v-if="suites && suites.length">
            <suite
                    v-for="suite of suites"
                    v-bind:suite="suite"
                    v-bind:key="suite.id">

            </suite>
        </template>
        <suite-create></suite-create>

        <ul v-if="errors && errors.length">
            <li v-for="error of errors">
                {{error.message}}
            </li>
        </ul>

    </div>
</template>

<script>
    import {HTTP} from '../Http/http-common';
    import Suite from './Suite';
    import SuiteCreate from './SuiteCreate';

    export default {
        name: 'dashboard',

        components: {
            Suite, SuiteCreate
        },
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

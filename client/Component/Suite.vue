<template>
    <section>
        <suite-nav v-bind:suite="suite"></suite-nav>
        <hr class="mb-2">

        <template v-if="suite.decks && suite.decks.length">
            <div class="row">

                <deck
                        v-for="deck of suite.decks"
                        v-bind:deck="deck"
                        v-bind:key="deck.id">
                </deck>

            </div>
        </template>

    </section>
</template>

<script>
    import {HTTP} from '../Http/http-common';
    import SuiteNav from './SuiteNav';
    import Deck from './Deck';

    export default {
        name: 'suite',
        components: {
            SuiteNav, Deck
        },
        props: ['suite']
    }
</script>

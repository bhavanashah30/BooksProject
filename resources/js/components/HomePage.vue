<template>
        <div class="row">
            <img :src="imagePath" class="image">
            <div class="col-2">
            </div>
            <div class="col-md-8">
                <div class="container">
                    <h1>Welcome to your personal book site</h1>
                    <div class="row">
                        <div class="col-1"></div>
                            <div class="col-8">
                                <h4>Please use one of the following Menu Options</h4>
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-8">
                                        <ul class="nav">
                                            <li class="nav-item">
                                                <a class="nav-link active" aria-current="page" :href="addUrl">Add Book</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" :href="showList">Display Books List</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" :href="bookSuggestions">Get Books Suggestion</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

</template>

<script>
    export default {
        data() {
            return {
                baseUrl: process.env.MIX_APP_URL,
                imagePath: process.env.MIX_IMAGE_PATH
            }
        },

        computed: {
            addUrl() {
                return process.env.MIX_APP_URL + '/add';
            },

            showList() {
                return process.env.MIX_APP_URL + '/books'
            },

            bookSuggestions() {
                return process.env.MIX_APP_URL + '/bookSuggestions'
            }

        }

    }
</script>

<style>
    .image{
        padding: 10px;
        height: 100px;
        width: 100%;
    }
</style>

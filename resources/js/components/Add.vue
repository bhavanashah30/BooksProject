<template>
    <div>
        <h4 style="padding: 50px;">Add new Book to your list:</h4>
        <div class="row">
            <div class="col-2"></div>
            <div class="box col-8">
                <div class="box-body">
                    <br/>
                    <label for="name">Book Name</label>
                    <input class="form-control" type="text" name="name" v-model="name"/><br/>
                    <label for="author">Author</label>
                    <input class="form-control" type="text" name="author" v-model="author"/><br/>
                    <label for="genre">Genre</label>
                    <input class="form-control" type="text" name="genre" v-model="genre"/><br/>
                    <button type="submit" class="btn btn-danger float-right" @click="onClose">Cancel</button>
                    <button type="submit" class="btn btn-danger float-right" @click="onSubmit">Submit</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "Add",

        data(){
            return {
                name: '',
                author: '',
                genre: ''
            }
        },

        methods: {
            onSubmit() {
                let url = process.env.MIX_APP_URL + '/api/saveBook';
                axios.post(url, {
                    data: {
                        bookName: this.name,
                        author: this.author,
                        genre: this.genre
                    }
                })
                    .then(function () {
                        swal2({
                            title: 'Success',
                            text: 'Book Added Successfully',
                            confirmButtonColor: '#dd4b39',
                            type: 'success',
                            confirmButtonText: 'OK'
                        })
                            .then(function (response) {
                                window.location.reload();
                            })

                    })
                    .catch(function (error) {
                        swal2({
                            title: 'Error',
                            text: 'Addition was unsuccessful. Please contact support.',
                            confirmButtonColor: '#dd4b39',
                            type: 'error',
                            confirmButtonText: 'OK'
                        })
                    })
            },

            onClose() {
                window.location.href = process.env.MIX_APP_URL;
            }
        }
    }
</script>

<template>
    <div class="row">
        <div class="col-5">
            <h4 style="padding: 20px">Click on the desired book for details and options!</h4>
            <div class="box">
                <div class="box-body">
                    <ag-grid-vue  class="ag-theme-fresh" style="width: 100%; height: 65vh;"
                                  :columnDefs="columnDefs"
                                  :rowData="books"
                                  :grid-options="gridOptions"
                                  @gridReady="onGridReady"
                                  @rowSelected="onSelect"
                                  rowSelection="single"
                                  :showGrid="true">
                    </ag-grid-vue>
                </div>
            </div>
        </div>
        <div v-if="openDetails" class="col-7">
            <h4 style="padding: 20px">Details</h4>
            <div class="box">
                <div class="box-body">
                   <label>Name:</label>
                   <input class="form-control" type="text" v-model="newBookName"></input>

                   <label>Author:</label>
                   <input class="form-control" type="text" v-model="newBookAuthor"></input>

                    <label>Genre:</label>
                   <input class="form-control" type="text" v-model="newBookGenre"></input>

                    <br/>
                    <button class="btn btn-success float-left" @click="updateBook">Update</button>
                    <button class="btn btn-danger float-left" style="padding-left: 5px" @click="deleteBook">Delete Book</button>
                    <button class="btn btn-danger float-right" @click="closeDetails">Close</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "BooksList",
        data() {
            return {
                books: [],
                columnDefs: [],
                gridOptions: {},
                openDetails: false,
                selectedBook: '',
                newBookName: '',
                newBookAuthor: '',
                newBookGenre: ''
            }
        },

        created() {
            this.getBooks();
            this.createColumnDefs();
            this.gridOptions = {
                context: {
                    componentParent: this
                },
                defaultColDef: {
                    filter: 'agTextColumnFilter',
                    sortable: true,
                    floatingFilter: true
                }
            }
        },

        methods:{
            getBooks(){
                let url = process.env.MIX_APP_URL + '/getBooks';
                let that = this;
                axios.get(url)
                    .then(function (response) {
                        that.books = response.data;
                    })
                    .catch(function (error) {
                        swal2(error);
                    })
            },

            createColumnDefs() {
                this.columnDefs = [
                    {
                        headerName: 'Book Name',
                        field: 'name'
                    },
                    {
                        headerName: 'Created At',
                        field: 'created_at'
                    }
                ]
            },

            onGridReady() {
              this.gridOptions.api.sizeColumnsToFit();
            },

            onSelect() {
                let params = this.gridOptions.api.getSelectedNodes()[0];
                this.openDetails = false;
                this.selectedBook = params.data;
                this.newBookName = params.data.name;
                this.newBookAuthor = params.data.detail.author;
                this.newBookGenre = params.data.detail.genre;
                this.openDetails = true;
            },

            updateBook() {
                let url = process.env.MIX_APP_URL + '/updateBook';
                axios.post(url, {
                    data: JSON.stringify({
                        bookName: this.newBookName,
                        author: this.newBookAuthor,
                        genre: this.newBookGenre,
                        id: this.selectedBook.id
                    })
                })
                    .then(function (response) {
                        swal2({
                            title: 'Success',
                            text: 'Update Successful',
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
                            text: 'Update was unsuccessful. Please contact support.',
                            confirmButtonColor: '#dd4b39',
                            type: 'error',
                            confirmButtonText: 'OK'
                        })
                    })

            },

            deleteBook() {
                let url = process.env.MIX_APP_URL + '/deleteBook/' + this.selectedBook.id;
                axios.delete(url)
                    .then(function (response) {
                        swal2({
                            title: 'Success',
                            text: 'Book Deleted Successfully',
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
                            text: 'Deletion was unsuccessful. Please contact support.',
                            confirmButtonColor: '#dd4b39',
                            type: 'error',
                            confirmButtonText: 'OK'
                        })
                    })


            },

            closeDetails() {
                this.openDetails = false;
                this.selectedBook = '';
                this.newBookName = '';
                this.newBookAuthor = '';
                this.newBookGenre = '';
            }
        }

    }
</script>

<style scoped>

</style>

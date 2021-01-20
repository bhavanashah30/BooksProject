<template>
    <div>
            <h4 style="padding: 20px">Books Suggestions</h4>
            <div class="box">
                <div class="box-body" v-if="books.length > 0">
                    <p>Note: This list is retrieved from google api.</p>
                    <ag-grid-vue  class="ag-theme-fresh" style="width: 100%; height: 50vh;"
                                  :columnDefs="columnDefs"
                                  :rowData="books"
                                  :grid-options="gridOptions"
                                  @gridReady="onGridReady"
                                  rowSelection="single"
                                  :showGrid="true">
                    </ag-grid-vue>
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
                let url = process.env.MIX_APP_URL + '/getBookSuggestions';
                let that = this;
                axios.get(url)
                    .then(function (response) {
                        that.books = response.data.items;
                    })
                    .catch(function (error) {
                        swal2(error);
                    })
            },

            createColumnDefs() {
                this.columnDefs = [
                    {
                        headerName: 'Book Title',
                        field: 'volumeInfo.title'
                    },
                    {
                        headerName: 'Description',
                        field: 'volumeInfo.description'
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
            }
        }

    }
</script>

<style scoped>

</style>

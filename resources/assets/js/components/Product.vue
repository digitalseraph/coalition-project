<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        My Products
                        <button @click="initAddProduct()" class="btn btn-primary btn-sm pull-right">
                            <span class="glyphicon glyphicon-plus"></span> Add New Product
                        </button>
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" v-if="products.length > 0">
                                <tbody>
                                    <tr>
                                        <th>
                                            No.
                                        </th>
                                        <th>
                                            Product Name
                                        </th>
                                        <th>
                                            Quantity in Stock
                                        </th>
                                        <th>
                                            Price per Item
                                        </th>
                                        <th>
                                            Datetime Submitted
                                        </th>
                                        <th>
                                            Total value number
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                    <tr v-for="(product, index) in products">
                                        <td>{{ index + 1 }}</td>
                                        <td style="white-space: nowrap">
                                            {{ product.name }}
                                        </td>
                                        <td style="white-space: nowrap">
                                            {{ product.quantity }}
                                        </td>
                                        <td style="white-space: nowrap">
                                            {{ product.price }}
                                        </td>
                                        <td style="white-space: nowrap">
                                            {{ product.created_at }}
                                        </td>
                                        <td style="white-space: nowrap">
                                            ${{ product.quantity * product.price }}
                                        </td>
                                        <td style="white-space: nowrap">
                                            <button @click="initUpdate(index)" class="btn btn-success btn-xs">Edit</button>
                                            <button @click="deleteProduct(index)" class="btn btn-danger btn-xs">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="add_product_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add New Product</h4>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" placeholder="Product Name" class="form-control"
                                   v-model="product.name">
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <input type="text" name="quantity" id="quantity" placeholder="Product Quantity" class="form-control"
                                   v-model="product.quantity">
                        </div>
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="text" name="price" id="price" placeholder="Product Price" class="form-control"
                                   v-model="product.price">
                        </div>                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="createProduct" class="btn btn-primary">Submit</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
 
        <div class="modal fade" tabindex="-1" role="dialog" id="update_product_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Update Product</h4>
                    </div>
                    <div class="modal-body">
 
                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>
 
                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" placeholder="Product Name" class="form-control"
                                   v-model="update_product.name">
                        </div>
                        <div class="form-group">
                            <label>Quantity:</label>
                            <input type="text" placeholder="Product Quantity" class="form-control"
                                   v-model="update_product.quantity">
                        </div>
                        <div class="form-group">
                            <label>Price:</label>
                            <input type="text" placeholder="Product Price" class="form-control"
                                   v-model="update_product.price">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="updateProduct" class="btn btn-primary">Submit</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div>
</template>

<script>
    export default {
        data(){
            return {
                product: {
                    name: '',
                    quantity: '',
                    price: ''
                },
                errors: [],
                products: [],
                update_product: {}
            }
        },
        filters: {
            truncate: function(value, length) {
                if(value.length < length) {
                    return value;
                }

                length = length - 3;

                return value.substring(0, length) + '...';
            },
            paragraphWrap: function(value) {
                return '<p>' + value + '</p>';
            }
        },
        mounted()
        {
            this.readProducts();
        },
        methods: {
            initAddProduct()
            {
                $("#add_product_model").modal("show");
            },
            createProduct()
            {
                axios.post('/product', {
                    name: this.product.name,
                    quantity: this.product.quantity,
                    price: this.product.price,
                })
                    .then(response => {

                        this.reset();

                        this.products.push(response.data.product);

                        $("#add_product_model").modal("hide");

                    })
                    .catch(error => {
                        this.errors = [];
                        if (error.response.data.errors.name) {
                            this.errors.push(error.response.data.errors.name[0]);
                        }

                        if (error.response.data.errors.quantity) {
                            this.errors.push(error.response.data.errors.quantity[0]);
                        }

                        if (error.response.data.errors.price) {
                            this.errors.push(error.response.data.errors.price[0]);
                        }
                    });
            },
            reset()
            {
                this.product.name = '';
                this.product.quantity = '';
                this.product.price = '';
            },
            readProducts()
            {
                axios.get('/product')
                    .then(response => {
 
                        this.products = response.data.products;
 
                    });
            },
            initUpdate(index)
            {
                this.errors = [];
                $("#update_product_model").modal("show");
                this.update_product = this.products[index];
            },
            updateProduct()
            {
                axios.patch('/product/' + this.update_product.id, {
                    name: this.update_product.name,
                    quantity: this.update_product.quantity,
                    price: this.update_product.price,
                })
                    .then(response => {
 
                        $("#update_product_model").modal("hide");
 
                    })
                    .catch(error => {
                        this.errors = [];
                        if (error.response.data.errors.name) {
                            this.errors.push(error.response.data.errors.name[0]);
                        }

                        if (error.response.data.errors.quantity) {
                            this.errors.push(error.response.data.errors.quantity[0]);
                        }

                        if (error.response.data.errors.price) {
                            this.errors.push(error.response.data.errors.price[0]);
                        }
                    });
            },
            deleteProduct(index)
            {
                let conf = confirm("Do you really want to delete this product?");
                if (conf === true) {
 
                    axios.delete('/product/' + this.products[index].id)
                        .then(response => {
 
                            this.products.splice(index, 1);
 
                        })
                        .catch(error => {
 
                        });
                }
            }
        }
    }
</script>

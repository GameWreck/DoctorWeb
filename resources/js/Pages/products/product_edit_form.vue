<script setup>
import Layout from '../layout.vue'
import {Head,Link} from '@inertiajs/vue3'
import {useForm} from '@inertiajs/vue3'

const  props = defineProps({
    product: {
      type:Array,
      default: () => ([])
    }
});


const {name,quantity,brand,model,category,stock,price}=props.product

const form = useForm({
     name:name,
     quantity:quantity,
     brand:brand,
     category:category,
     model:model,
     stock:stock,
     price:price,
     image:null
})


</script>

<template>
    <Head :title="'Product Edit'"></Head>
    <Layout>
        <div class="col-xl">
   <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
         <h5 class="mb-0">Update prouduct</h5>
         <h5 class="float-end">
            <Link :href="route('dashboard.products')">Back</Link>
         </h5>
      </div>
      <div class="card-body">
         <form @submit.prevent="form.put(route('dashboard.product.update'))">
            <div class="mb-3">
               <label class="form-label" for="name">Name</label>
               <input v-model="form.name" type="text" class="form-control"  placeholder="Product name">
               <span class="text-danger" v-if="form.errors.name">{{ form.errors.name }}</span>
            </div>
            <div class="mb-3">
               <label class="form-label" for="quantity">Quantity</label>
               <input v-model="form.quantity" type="number" class="form-control" placeholder="Product quantity">
               <span class="text-danger" v-if="form.errors.quantity">{{ form.errors.quantity }}</span>
            </div>
            <div class="mb-3">
               <label class="form-label" for="brand">Brand</label>
               <input v-model="form.brand" type="text" class="form-control" placeholder="Product brand">
               <span class="text-danger" v-if="form.errors.brand">{{ form.errors.brand }}</span>
            </div>
            <div class="mb-3">
               <label class="form-label" for="brand">Model</label>
               <input v-model="form.model" type="text" class="form-control" placeholder="Product model">
               <span class="text-danger" v-if="form.errors.model">{{ form.errors.model }}</span>
            </div>
            <div class="mb-3">
               <label class="form-label" for="category">Category</label>
               <input v-model="form.category" type="text"  class="form-control" placeholder="Product category">
               <span class="text-danger" v-if="form.errors.category">{{ form.errors.category }}</span>
            </div>
            <div class="mb-3">
               <label class="form-label" for="category">stock</label>
               <select  v-model="form.stock"  class="form-select"  aria-label="Default select example">
                    <option selected >select</option>
                    <option>instock</option>
                    <option>outofstock</option>
                </select>
               <span class="text-danger" v-if="form.errors.stock">{{ form.errors.stock }}</span>
            </div>
            <div class="mb-3">
               <label class="form-label" for="price">Price</label>
               <input v-model="form.price" type="number" class="form-control" placeholder="Product price">
               <span class="text-danger" v-if="form.errors.quantity">{{ form.errors.quantity }}</span>
            </div>
            <div class="mb-3">
               <label class="form-label" for="file">Image</label>
               <input type="file" class="form-control" @input="form.image = $event.target.files[0]" />
               <span class="text-danger" v-if="form.errors.image">{{ form.errors.image }}</span>
            </div>
            <button type="submit"  class="btn btn-primary" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
               <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                  <span class="visually-hidden">Loading...</span>
               </div>
               Update
            </button>
         </form>
      </div>
   </div>
</div>
    </Layout>
</template>
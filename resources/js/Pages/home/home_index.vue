<script setup>
import Layout from '../layout.vue'
import Modal from '../components/modal.vue'
import { Head } from '@inertiajs/vue3'
import { reactive } from 'vue';
import { useForm } from '@inertiajs/vue3'


const state = reactive({showModal:false,users: []})

const form = useForm({
     name:null,
})

const showModal=()=>{
     state.showModal=true
}

const closeModal=()=>{
    state.showModal=false
    form.reset();
}


const create=()=>{
    state.users.push(form)
    closeModal();
    
}

const destroy=(index)=>{
     state.users.splice(index,1);
}

</script>

<template>
    <Head :title="'Home'" ></Head>
    <Layout>
        <Modal v-if="state.showModal" :title="'Create User'">
            <template #header>
                <button class="btn-close" @click="closeModal"></button>
            </template>
            <template #body>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                        <div class="col-sm-10">
                            <input v-model="form.name" type="text" class="form-control" placeholder="Enter name">
                        </div>
                    </div>
            </template>
            <template #footer>
                <button type="button" @click="closeModal" class="btn btn-dark">Close</button>
                <button type="submit" @click="create" class="btn btn-primary" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        Save
                </button>
            </template>
        </Modal>
        <div class="card __web-inspector-hide-shortcut__">
        <div class="card-header">
            <button @click="showModal" type="button" class="btn btn-success">Create</button>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th>name</th>
                    <th>email</th>
                    <th>phone</th>
                    <th>actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr v-for="(user,index) in state.users">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }} </td>
                        <td>{{ user.email }} </td>
                        <div class="row ">
                          <div class="col-6">
                             <button @click="openModalUpdate(index)" type="button"  class="btn btn-warning mx-1">Edit</button>
                             <button @click="destroy(index)" type="button" class="btn btn-danger mx-1">Delete</button>
                          </div>
                      </div>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </Layout>
</template>

<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'

defineProps({
  errors: Object
})

const form = reactive({
  title: null,
  content: null
})
const submitFunction = () => {
  router.post('/inertia', form)
}
</script>
<template>
  <form @submit.prevent="submitFunction">
    <input type="text" name="title" v-model="form.title">
    <div v-if="errors.title">{{ errors.title }}</div><br>
    <input type="text" name="content" v-model="form.content">
    <div v-if="errors.content">{{ errors.content }}</div><br>
    <button>送信</button>
  </form>
</template>
<script setup>
import { ref } from 'vue';
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import GuestLayout from '@/Layouts/GuestLayout.vue'

const aaa = ref('こんにちは');
</script>
<template>
    <GuestLayout>
        <InputLabel value="タイトル"></InputLabel>
        <TextInput v-model="aaa"></TextInput>
    </GuestLayout>
</template>
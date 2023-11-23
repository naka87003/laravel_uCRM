<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { nl2br } from '@/common.js';

const props = defineProps({
  customer: Object
})

const deleteCustomer = id => {
  router.delete(route('customers.destroy', { customer: id }), {
    onBefore: () => confirm('本当に削除しますか?')
  })
}
</script>

<template>
  <Head title="商品情報" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">顧客情報</h2>
    </template>
    <section class="text-gray-600 body-font relative">
      <div class="container px-5 py-8 mx-auto">
        <div class="lg:w-1/2 md:w-2/3 mx-auto">
          <div class="flex flex-wrap -m-2">
            <div class="p-2 w-full">
              <div class="relative">
                <label for="name" class="leading-7 text-sm text-gray-600">顧客名</label>
                <div id="name"
                  class="w-full bg-opacity-50 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  {{ props.customer.name }}</div>
              </div>
            </div>
            <div class="p-2 w-full">
              <div class="relative">
                <label for="kana" class="leading-7 text-sm text-gray-600">フリガナ</label>
                <div id="kana"
                  class="w-full bg-opacity-50 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  {{ props.customer.kana }}</div>
              </div>
            </div>
            <div class="p-2 w-full">
              <div class="relative">
                <label for="tel" class="leading-7 text-sm text-gray-600">電話番号</label>
                <div id="tel"
                  class="w-full bg-opacity-50 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  {{ props.customer.tel }}</div>
              </div>
            </div>
            <div class="p-2 w-full">
              <div class="relative">
                <label for="email" class="leading-7 text-sm text-gray-600">メールアドレス</label>
                <div id="email"
                  class="w-full bg-opacity-50 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  {{ props.customer.email }}</div>
              </div>
            </div>
            <div class="p-2 w-full">
              <div class="relative">
                <label for="postcode" class="leading-7 text-sm text-gray-600">郵便番号</label>
                <div id="postcode"
                  class="w-full bg-opacity-50 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  {{ props.customer.postcode }}</div>
              </div>
            </div>
            <div class="p-2 w-full">
              <div class="relative">
                <label for="address" class="leading-7 text-sm text-gray-600">住所</label>
                <div id="address"
                  class="w-full bg-opacity-50 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  {{ props.customer.address }}</div>
              </div>
            </div>
            <div class="p-2 w-full">
              <div class="relative">
                <label for="birthday" class="leading-7 text-sm text-gray-600">誕生日</label>
                <div id="birthday"
                  class="w-full bg-opacity-50 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  {{ props.customer.birthday }}</div>
              </div>
            </div>
            <div class="p-2 w-full">
              <div class="relative">
                <label for="gender" class="leading-7 text-sm text-gray-600">性別</label>
                <div id="gender"
                  class="w-full bg-opacity-50 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  <span v-if="customer.gender === 0">男性</span>
                  <span v-if="customer.gender === 1">女性</span>
                  <span v-if="customer.gender === 2">未回答</span>
                </div>
              </div>
            </div>
            <div class="p-2 w-full">
              <div class="relative">
                <label for="memo">メモ</label>
                <div id="memo"
                  class="w-full bg-opacity-50 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                  v-html="nl2br(props.customer.memo)"></div>
              </div>
            </div>
            <div class="flex pl-4 my-4 lg:w-2/3 w-full mx-auto">
              <div class="flex justify-center">
                <Link as="button"
                  class="inline-flex text-white bg-green-500 border-0 py-2 px-6 focus:outline-none hover:bg-green-600 rounded text-lg"
                  :href="route('customers.edit', { customer: customer.id })">編集する</Link>
                <button
                  class="ml-4 inline-flex text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded text-lg"
                  @click="deleteCustomer(customer.id)">削除する</button>
                <Link as="button"
                  class="ml-4 inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                  :href="route('customers.index')">商品一覧へ</Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </AuthenticatedLayout>
</template>

<script setup>
const props = defineProps({ 'data': Object });
</script>

<template>
  <div v-show="props.data.data" class="2xl:w-2/3 w-full mx-auto overflow-auto">
    <div v-if="data.type === 'decile'">
      <table class="table-auto w-full text-left whitespace-no-wrap">
        <thead>
          <tr>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">グループ</th>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">平均</th>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">金額</th>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">構成比</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in props.data.data" :key="item.date">
            <td class="border-t-2 border-gray-200 px-4 py-3">{{ item.decile }}</td>
            <td class="border-t-2 border-gray-200 px-4 py-3">{{ item.average }}</td>
            <td class="border-t-2 border-gray-200 px-4 py-3">{{ item.totalPerGroup }}</td>
            <td class="border-t-2 border-gray-200 px-4 py-3">{{ item.totalRatio }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else-if="data.type === 'perDay' || data.type === 'perMonth' || data.type === 'perYear'">
      <table class="table-auto w-full text-left whitespace-no-wrap">
        <thead>
          <tr>
            <th
              class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
              日付</th>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
              金額</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in props.data.data" :key="item.date">
            <td class="border-t-2 border-gray-200 px-4 py-3">{{ item.date }}</td>
            <td class="border-t-2 border-gray-200 px-4 py-3">{{ item.total }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else-if="data.type === 'rfm'">
      <h2 class="block leading-7 text-xl text-gray-600">RFM分析結果</h2>
      <div class="my-4 text-left">合計: {{ data.totals }} 人</div>
      <h3 class="block leading-7 text-lg text-gray-600 mt-4">RFMランク毎の人数</h3>
      <table class="table-auto w-full text-left whitespace-no-wrap">
        <thead>
          <th
            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
            ランク</th>
          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
            R</th>
          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
            F</th>
          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
            M</th>
        </thead>
        <tbody>
          <tr v-for="rfm in  props.data.eachCount " :key="rfm.rank">
            <td class="border-t-2 border-gray-200 px-4 py-3">{{ rfm.rank }}</td>
            <td class="border-t-2 border-gray-200 px-4 py-3"> {{ rfm.r }}</td>
            <td class="border-t-2 border-gray-200 px-4 py-3"> {{ rfm.f }}</td>
            <td class="border-t-2 border-gray-200 px-4 py-3"> {{ rfm.m }}</td>
          </tr>
        </tbody>
      </table>
      <h3 class="block leading-7 text-lg text-gray-600 mt-4">RF集計表</h3>
      <table class="table-auto w-full text-left whitespace-no-wrap">
        <thead>
          <th
            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
            R</th>
          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
            F5</th>
          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
            F4</th>
          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
            F3</th>
          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
            F2</th>
          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
            F1</th>
        </thead>
        <tbody>
          <tr v-for="rf in props.data.data" :key="rf.rRank">
            <td class="border-t-2 border-gray-200 px-4 py-3">{{ rf.rRank }}</td>
            <td class="border-t-2 border-gray-200 px-4 py-3">{{ rf.f_5 }}</td>
            <td class="border-t-2 border-gray-200 px-4 py-3">{{ rf.f_4 }}</td>
            <td class="border-t-2 border-gray-200 px-4 py-3">{{ rf.f_3 }}</td>
            <td class="border-t-2 border-gray-200 px-4 py-3">{{ rf.f_2 }}</td>
            <td class="border-t-2 border-gray-200 px-4 py-3">{{ rf.f_1 }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template >

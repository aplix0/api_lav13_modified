<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noted Money Backup Monitor</title>

    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/app.js'])

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif']
                    },
                    boxShadow: {
                        soft: '0 24px 70px rgba(15, 23, 42, 0.10)',
                        glow: '0 0 0 1px rgba(255,255,255,0.08), 0 24px 80px rgba(14,165,233,0.18)'
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
        }

        .mesh-bg {
            background:
                radial-gradient(circle at top left, rgba(56, 189, 248, 0.28), transparent 34%),
                radial-gradient(circle at top right, rgba(99, 102, 241, 0.24), transparent 30%),
                radial-gradient(circle at bottom left, rgba(16, 185, 129, 0.18), transparent 32%),
                linear-gradient(135deg, #020617 0%, #0f172a 42%, #111827 100%);
        }

        .glass {
            background: rgba(255, 255, 255, 0.78);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .dark-glass {
            background: rgba(15, 23, 42, 0.72);
            backdrop-filter: blur(22px);
            -webkit-backdrop-filter: blur(22px);
        }

        .soft-scroll::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .soft-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }

        .soft-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .skeleton {
            background: linear-gradient(90deg, #e2e8f0 25%, #f8fafc 37%, #e2e8f0 63%);
            background-size: 400% 100%;
            animation: shimmer 1.4s ease infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: 100% 0;
            }

            100% {
                background-position: -100% 0;
            }
        }

        @media (max-width: 640px) {
            .mobile-safe-title {
                line-height: 1.05;
                letter-spacing: -0.04em;
            }

            .mobile-card-radius {
                border-radius: 1.25rem;
            }
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-950 antialiased">
    <div class="min-h-screen">
        <section class="mesh-bg relative overflow-hidden">
            <div class="absolute inset-0 opacity-30">
                <div class="absolute left-4 top-16 h-24 w-24 rounded-full bg-cyan-400 blur-3xl sm:left-10 sm:h-28 sm:w-28"></div>
                <div class="absolute right-4 top-28 h-28 w-28 rounded-full bg-indigo-500 blur-3xl sm:right-20 sm:top-20 sm:h-36 sm:w-36"></div>
                <div class="absolute bottom-4 left-1/2 h-24 w-24 rounded-full bg-emerald-400 blur-3xl sm:h-28 sm:w-28"></div>
            </div>

            <div class="relative mx-auto max-w-7xl px-4 py-5 sm:px-6 sm:py-7 lg:px-8">
                <nav class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white text-lg font-black text-slate-950 shadow-glow">
                            NM
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-white">Noted Money</p>
                            <p class="text-xs text-slate-300">Backup Monitor</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 xs:flex-row sm:flex-row sm:items-center">
                        <div id="statusBadge" class="flex w-fit items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold text-white sm:text-sm">
                            <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-400"></span>
                            Realtime aktif
                        </div>

                        <button onclick="loadAll(true)" class="w-full rounded-full bg-white px-4 py-2 text-sm font-bold text-slate-950 shadow-lg shadow-cyan-950/20 transition hover:scale-[1.02] hover:bg-slate-100 sm:w-auto">
                            Sync sekarang
                        </button>
                    </div>
                </nav>

                <div class="grid gap-8 py-10 sm:py-12 lg:grid-cols-12 lg:items-end lg:py-14">
                    <div class="lg:col-span-7">
                        <p class="mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold text-cyan-100 sm:text-sm">
                            Dashboard Backup
                        </p>

                        <h1 class="mobile-safe-title max-w-4xl text-3xl font-black tracking-tight text-white sm:text-5xl lg:text-6xl">
                            Pantau backup Noted Money secara langsung.
                        </h1>

                        <p class="mt-5 max-w-2xl text-sm leading-6 text-slate-300 sm:text-lg sm:leading-8">
                            Lihat ringkasan, daftar backup, dan detail transaksi dalam satu dashboard tanpa memuat ulang halaman.
                        </p>
                    </div>

                    <div class="lg:col-span-5">
                        <div class="dark-glass mobile-card-radius rounded-3xl border border-white/10 p-4 shadow-glow sm:p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-sm text-slate-300">Saldo backup</p>
                                    <h2 id="heroSaldo" class="mt-2 break-words text-3xl font-black text-white sm:text-4xl">Rp0</h2>
                                </div>

                                <div class="shrink-0 rounded-2xl bg-emerald-400/15 px-3 py-2 text-xs font-bold text-emerald-300">
                                    LIVE
                                </div>
                            </div>

                            <div class="mt-6 grid grid-cols-1 gap-3 min-[420px]:grid-cols-2">
                                <div class="rounded-2xl bg-white/10 p-4">
                                    <p class="text-xs text-slate-300">Pemasukan</p>
                                    <p id="heroPemasukan" class="mt-1 break-words text-lg font-bold text-emerald-300 sm:text-xl">Rp0</p>
                                </div>

                                <div class="rounded-2xl bg-white/10 p-4">
                                    <p class="text-xs text-slate-300">Pengeluaran</p>
                                    <p id="heroPengeluaran" class="mt-1 break-words text-lg font-bold text-red-300 sm:text-xl">Rp0</p>
                                </div>
                            </div>

                            <div class="mt-5 rounded-2xl bg-white/10 p-4">
                                <div class="flex flex-col gap-1 text-sm min-[420px]:flex-row min-[420px]:items-center min-[420px]:justify-between">
                                    <span class="text-slate-300">Sinkronisasi</span>
                                    <span id="lastSyncHero" class="font-semibold text-white">Menunggu data</span>
                                </div>

                                <div class="mt-3 h-2 overflow-hidden rounded-full bg-white/10">
                                    <div id="syncBar" class="h-full w-2/3 rounded-full bg-cyan-400 transition-all"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <main class="relative mx-auto -mt-8 max-w-7xl px-4 pb-8 sm:-mt-10 sm:px-6 sm:pb-10 lg:px-8">
            <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
                <div class="glass mobile-card-radius rounded-3xl border border-white p-4 shadow-soft sm:p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-slate-500">Total Backup</p>
                        <div class="rounded-2xl bg-cyan-50 px-3 py-2 text-cyan-700">↗</div>
                    </div>
                    <h2 id="totalBackup" class="mt-4 text-3xl font-black">0</h2>
                    <p class="mt-1 text-xs text-slate-500">Jumlah sesi backup yang masuk</p>
                </div>

                <div class="glass mobile-card-radius rounded-3xl border border-white p-4 shadow-soft sm:p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-slate-500">Total Transaksi</p>
                        <div class="rounded-2xl bg-indigo-50 px-3 py-2 text-indigo-700">◆</div>
                    </div>
                    <h2 id="totalTransaksi" class="mt-4 text-3xl font-black">0</h2>
                    <p class="mt-1 text-xs text-slate-500">Data transaksi dari seluruh backup</p>
                </div>

                <div class="glass mobile-card-radius rounded-3xl border border-white p-4 shadow-soft sm:p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-slate-500">Pemasukan</p>
                        <div class="rounded-2xl bg-emerald-50 px-3 py-2 text-emerald-700">+</div>
                    </div>
                    <h2 id="totalPemasukan" class="mt-4 break-words text-2xl font-black text-emerald-600 sm:text-3xl">Rp0</h2>
                    <p class="mt-1 text-xs text-slate-500">Total uang masuk</p>
                </div>

                <div class="glass mobile-card-radius rounded-3xl border border-white p-4 shadow-soft sm:p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-slate-500">Pengeluaran</p>
                        <div class="rounded-2xl bg-red-50 px-3 py-2 text-red-700">−</div>
                    </div>
                    <h2 id="totalPengeluaran" class="mt-4 break-words text-2xl font-black text-red-600 sm:text-3xl">Rp0</h2>
                    <p class="mt-1 text-xs text-slate-500">Total uang keluar</p>
                </div>

                <div class="glass mobile-card-radius rounded-3xl border border-white p-4 shadow-soft sm:col-span-2 sm:p-5 lg:col-span-1 xl:col-span-1">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-slate-500">Saldo</p>
                        <div class="rounded-2xl bg-slate-100 px-3 py-2 text-slate-700">Σ</div>
                    </div>
                    <h2 id="totalSaldo" class="mt-4 break-words text-2xl font-black sm:text-3xl">Rp0</h2>
                    <p class="mt-1 text-xs text-slate-500">Pemasukan dikurangi pengeluaran</p>
                </div>
            </section>

            <section class="mt-6 grid gap-6 lg:grid-cols-12">
                <aside class="lg:col-span-5">
                    <div class="mobile-card-radius overflow-hidden rounded-3xl border border-white bg-white shadow-soft">
                        <div class="border-b border-slate-100 p-4 sm:p-5">
                            <div class="flex flex-col gap-4 min-[420px]:flex-row min-[420px]:items-start min-[420px]:justify-between">
                                <div>
                                    <h2 class="text-lg font-black sm:text-xl">Daftar Backup</h2>
                                    <p id="lastSync" class="mt-1 text-sm text-slate-500">Menunggu sinkronisasi</p>
                                </div>

                                <span id="backupCounter" class="w-fit rounded-full bg-slate-950 px-3 py-1 text-xs font-bold text-white">
                                    0 data
                                </span>
                            </div>

                            <div class="mt-5">
                                <div class="relative">
                                    <input
                                        id="searchBackup"
                                        type="text"
                                        placeholder="Cari nama backup atau ID..."
                                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 pl-11 text-sm outline-none transition focus:border-slate-950 focus:bg-white">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                        ⌕
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="backupList" class="soft-scroll max-h-[520px] overflow-y-auto p-4 sm:max-h-[690px]">
                            <div class="space-y-3">
                                <div class="skeleton h-28 rounded-3xl"></div>
                                <div class="skeleton h-28 rounded-3xl"></div>
                                <div class="skeleton h-28 rounded-3xl"></div>
                            </div>
                        </div>
                    </div>
                </aside>

                <section class="lg:col-span-7">
                    <div class="mobile-card-radius overflow-hidden rounded-3xl border border-white bg-white shadow-soft">
                        <div class="border-b border-slate-100 p-4 sm:p-5">
                            <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                                <div>
                                    <h2 class="text-lg font-black sm:text-xl">Detail Transaksi</h2>
                                    <p id="detailTitle" class="mt-1 text-sm text-slate-500">
                                        Pilih backup untuk melihat rincian transaksi.
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 gap-2 min-[420px]:grid-cols-3">
                                    <div class="rounded-2xl bg-emerald-50 px-4 py-3">
                                        <p class="text-xs font-semibold text-emerald-700">Masuk</p>
                                        <p id="detailPemasukan" class="mt-1 break-words text-sm font-black text-emerald-700">Rp0</p>
                                    </div>

                                    <div class="rounded-2xl bg-red-50 px-4 py-3">
                                        <p class="text-xs font-semibold text-red-700">Keluar</p>
                                        <p id="detailPengeluaran" class="mt-1 break-words text-sm font-black text-red-700">Rp0</p>
                                    </div>

                                    <div class="rounded-2xl bg-slate-100 px-4 py-3">
                                        <p class="text-xs font-semibold text-slate-700">Saldo</p>
                                        <p id="detailSaldo" class="mt-1 break-words text-sm font-black text-slate-950">Rp0</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="detailCards" class="soft-scroll max-h-[560px] overflow-y-auto p-4 md:hidden">
                            <div class="rounded-3xl bg-slate-50 px-5 py-12 text-center">
                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-white text-2xl shadow-sm">
                                    ⌁
                                </div>
                                <h3 class="mt-5 text-lg font-black">Belum ada backup dipilih</h3>
                                <p class="mt-2 text-sm leading-6 text-slate-500">
                                    Pilih salah satu data backup untuk melihat transaksi secara detail.
                                </p>
                            </div>
                        </div>

                        <div class="soft-scroll hidden max-h-[690px] overflow-auto md:block">
                            <table class="w-full min-w-[760px] text-left text-sm">
                                <thead class="sticky top-0 z-10 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                                    <tr>
                                        <th class="px-5 py-4">Tanggal</th>
                                        <th class="px-5 py-4">Uraian</th>
                                        <th class="px-5 py-4">Jenis</th>
                                        <th class="px-5 py-4 text-right">Nominal</th>
                                    </tr>
                                </thead>

                                <tbody id="detailTable" class="divide-y divide-slate-100">
                                    <tr>
                                        <td colspan="4" class="px-5 py-20 text-center">
                                            <div class="mx-auto max-w-sm">
                                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-slate-100 text-2xl">
                                                    ⌁
                                                </div>
                                                <h3 class="mt-5 text-lg font-black">Belum ada backup dipilih</h3>
                                                <p class="mt-2 text-sm leading-6 text-slate-500">
                                                    Pilih salah satu data backup untuk melihat transaksi secara detail.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </section>
        </main>

        <footer class="mx-auto max-w-7xl px-4 pb-6 sm:px-6 sm:pb-8 lg:px-8">
            <div class="mobile-card-radius overflow-hidden rounded-3xl border border-white bg-slate-950 shadow-soft">
                <div class="grid gap-6 px-5 py-6 sm:px-6 md:grid-cols-3 md:items-center">
                    <div>
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-white text-sm font-black text-slate-950">
                                NM
                            </div>

                            <div>
                                <p class="font-bold text-white">Noted Money</p>
                                <p class="text-xs text-slate-400">Backup Monitor</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-sm leading-6 text-slate-300 md:text-center">
                        Data tersinkron otomatis setiap 2 detik.
                    </div>

                    <div class="text-sm text-slate-400 md:text-right">
                        <p>Terakhir sync: <span id="footerSync" class="font-semibold text-white">Menunggu data</span></p>
                        <p class="mt-1">© <span id="footerYear"></span> Noted Money</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <div id="toast" class="pointer-events-none fixed bottom-4 left-4 right-4 z-50 hidden rounded-2xl bg-slate-950 px-5 py-4 text-center text-sm font-semibold text-white shadow-2xl sm:left-auto sm:right-5 sm:w-fit">
        Data berhasil disinkronkan
    </div>

    <script>
        let selectedBackupId = null
        let backupCache = []
        let lastBackupFingerprint = ''
        let isLoading = false
        let searchKeyword = ''

        const endpoint = {
            list: '/api/daftar_backup',
            detail: '/api/detail_backup',
            summary: '/api/ringkasan_backup'
        }

        const el = {
            statusBadge: document.getElementById('statusBadge'),
            totalBackup: document.getElementById('totalBackup'),
            totalTransaksi: document.getElementById('totalTransaksi'),
            totalPemasukan: document.getElementById('totalPemasukan'),
            totalPengeluaran: document.getElementById('totalPengeluaran'),
            totalSaldo: document.getElementById('totalSaldo'),
            heroSaldo: document.getElementById('heroSaldo'),
            heroPemasukan: document.getElementById('heroPemasukan'),
            heroPengeluaran: document.getElementById('heroPengeluaran'),
            lastSync: document.getElementById('lastSync'),
            lastSyncHero: document.getElementById('lastSyncHero'),
            footerSync: document.getElementById('footerSync'),
            footerYear: document.getElementById('footerYear'),
            backupCounter: document.getElementById('backupCounter'),
            backupList: document.getElementById('backupList'),
            detailTitle: document.getElementById('detailTitle'),
            detailTable: document.getElementById('detailTable'),
            detailCards: document.getElementById('detailCards'),
            detailPemasukan: document.getElementById('detailPemasukan'),
            detailPengeluaran: document.getElementById('detailPengeluaran'),
            detailSaldo: document.getElementById('detailSaldo'),
            searchBackup: document.getElementById('searchBackup'),
            syncBar: document.getElementById('syncBar'),
            toast: document.getElementById('toast')
        }

        el.footerYear.textContent = new Date().getFullYear()

        function rupiah(value) {
            const number = Number(value || 0)
            return 'Rp' + number.toLocaleString('id-ID')
        }

        function escapeHtml(value) {
            return String(value ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;')
        }

        function formatDate(value) {
            if (!value) return '-'

            const normalized = String(value).replace(' ', 'T')
            const date = new Date(normalized)

            if (isNaN(date.getTime())) return value

            return date.toLocaleString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            })
        }

        function setStatus(text, type = 'success') {
            let color = 'bg-emerald-500'
            let dot = 'bg-emerald-200'

            if (type === 'warning') {
                color = 'bg-amber-500'
                dot = 'bg-amber-100'
            }

            if (type === 'error') {
                color = 'bg-red-500'
                dot = 'bg-red-200'
            }

            el.statusBadge.className = `flex w-fit items-center gap-2 rounded-full border border-white/15 px-4 py-2 text-xs font-semibold text-white sm:text-sm ${color}`
            el.statusBadge.innerHTML = `<span class="h-2 w-2 animate-pulse rounded-full ${dot}"></span>${text}`
        }

        function showToast(text) {
            el.toast.textContent = text
            el.toast.classList.remove('hidden')

            setTimeout(() => {
                el.toast.classList.add('hidden')
            }, 1800)
        }

        async function fetchJson(url, options = {}) {
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    ...(options.headers || {})
                },
                ...options
            })

            if (!response.ok) {
                throw new Error('HTTP ' + response.status)
            }

            return await response.json()
        }

        async function loadSummary() {
            const json = await fetchJson(endpoint.summary)
            const data = json.data || {}

            el.totalBackup.textContent = data.total_backup || 0
            el.totalTransaksi.textContent = data.total_transaksi || 0
            el.totalPemasukan.textContent = rupiah(data.total_pemasukan)
            el.totalPengeluaran.textContent = rupiah(data.total_pengeluaran)
            el.totalSaldo.textContent = rupiah(data.saldo)

            el.heroSaldo.textContent = rupiah(data.saldo)
            el.heroPemasukan.textContent = rupiah(data.total_pemasukan)
            el.heroPengeluaran.textContent = rupiah(data.total_pengeluaran)
        }

        async function loadBackupList(forceRender = false) {
            const json = await fetchJson(endpoint.list)
            const data = Array.isArray(json.data) ? json.data : []

            backupCache = data

            const now = new Date().toLocaleTimeString('id-ID')
            el.backupCounter.textContent = data.length + ' data'
            el.lastSync.textContent = 'Sinkron terakhir: ' + now
            el.lastSyncHero.textContent = now
            el.footerSync.textContent = now

            const fingerprint = JSON.stringify(data.map(item => [
                item.id,
                item.nama,
                item.waktu,
                item.total_transaksi,
                item.saldo
            ]))

            if (forceRender || fingerprint !== lastBackupFingerprint) {
                renderBackupList()
                lastBackupFingerprint = fingerprint
            }

            if (selectedBackupId) {
                await loadDetail(selectedBackupId, false)
            }
        }

        function renderBackupList() {
            const keyword = searchKeyword.toLowerCase()

            const filtered = backupCache.filter(item => {
                const nama = String(item.nama || '').toLowerCase()
                const id = String(item.id || '').toLowerCase()
                return nama.includes(keyword) || id.includes(keyword)
            })

            if (!filtered.length) {
                el.backupList.innerHTML = `
                <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-6 text-center sm:p-8">
                    <h3 class="font-black text-slate-950">Backup tidak ditemukan</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Coba gunakan kata kunci lain atau lakukan backup baru dari aplikasi Noted Money.
                    </p>
                </div>
            `
                return
            }

            el.backupList.innerHTML = filtered.map(item => {
                const isActive = String(item.id) === String(selectedBackupId)
                const activeClass = isActive ? 'border-slate-950 bg-slate-50 shadow-lg' : 'border-slate-200 bg-white'

                return `
                <button
                    type="button"
                    data-id="${escapeHtml(item.id)}"
                    class="backup-card mb-3 w-full rounded-3xl border p-4 text-left transition duration-200 hover:-translate-y-0.5 hover:border-slate-950 hover:bg-slate-50 hover:shadow-lg ${activeClass}"
                >
                    <div class="flex flex-col gap-3 min-[420px]:flex-row min-[420px]:items-start min-[420px]:justify-between">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-emerald-500"></span>
                                <h3 class="truncate font-black text-slate-950">${escapeHtml(item.nama)}</h3>
                            </div>

                            <p class="mt-2 break-all text-xs font-medium text-slate-500">ID ${escapeHtml(item.id)}</p>
                            <p class="mt-1 text-xs text-slate-400">${formatDate(item.waktu)}</p>
                        </div>

                        <span class="w-fit rounded-full bg-slate-950 px-3 py-1 text-xs font-bold text-white">
                            ${escapeHtml(item.channel || 'laravel')}
                        </span>
                    </div>

                    <div class="mt-4 grid grid-cols-1 gap-2 min-[420px]:grid-cols-3">
                        <div class="rounded-2xl bg-slate-100 p-3">
                            <p class="text-[11px] font-semibold text-slate-500">Transaksi</p>
                            <p class="mt-1 font-black text-slate-950">${item.total_transaksi || 0}</p>
                        </div>

                        <div class="rounded-2xl bg-emerald-50 p-3">
                            <p class="text-[11px] font-semibold text-emerald-700">Masuk</p>
                            <p class="mt-1 break-words font-black text-emerald-700">${rupiah(item.total_pemasukan)}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-100 p-3">
                            <p class="text-[11px] font-semibold text-slate-500">Saldo</p>
                            <p class="mt-1 break-words font-black text-slate-950">${rupiah(item.saldo)}</p>
                        </div>
                    </div>
                </button>
            `
            }).join('')
        }

        async function loadDetail(idBackup, forceRenderList = false) {
            selectedBackupId = idBackup

            const json = await fetchJson(endpoint.detail, {
                method: 'POST',
                body: JSON.stringify({
                    idbackup: idBackup
                })
            })

            const data = Array.isArray(json.data) ? json.data : []

            el.detailTitle.textContent = 'Detail backup ID: ' + idBackup
            renderDetail(data)

            if (forceRenderList) {
                renderBackupList()
            }
        }

        function renderDetail(data) {
            if (!data.length) {
                el.detailCards.innerHTML = `
                <div class="rounded-3xl bg-slate-50 px-5 py-12 text-center">
                    <h3 class="mt-5 text-lg font-black">Detail tidak tersedia</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Backup ini belum memiliki transaksi atau data tidak ditemukan.
                    </p>
                </div>
            `

                el.detailTable.innerHTML = `
                <tr>
                    <td colspan="4" class="px-5 py-20 text-center">
                        Detail tidak tersedia
                    </td>
                </tr>
            `

                el.detailPemasukan.textContent = rupiah(0)
                el.detailPengeluaran.textContent = rupiah(0)
                el.detailSaldo.textContent = rupiah(0)
                return
            }

            let pemasukan = 0
            let pengeluaran = 0

            el.detailCards.innerHTML = data.map(item => {
                const nominal = Number(item.nominal || 0)
                const isIncome = item.jenis === '+'

                if (isIncome) {
                    pemasukan += nominal
                } else {
                    pengeluaran += nominal
                }

                return `
                <div class="mb-3 rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
                    <p class="font-black text-slate-950">${escapeHtml(item.uraian)}</p>
                    <p class="mt-1 text-xs text-slate-400">${formatDate(item.tgl_jam)}</p>
                    <p class="mt-4 break-words text-xl font-black ${isIncome ? 'text-emerald-700' : 'text-red-700'}">
                        ${isIncome ? '+' : '-'} ${rupiah(nominal)}
                    </p>
                </div>
            `
            }).join('')

            el.detailTable.innerHTML = data.map(item => {
                const nominal = Number(item.nominal || 0)
                const isIncome = item.jenis === '+'

                return `
                <tr class="transition hover:bg-slate-50">
                    <td class="whitespace-nowrap px-5 py-4 text-slate-600">
                        ${formatDate(item.tgl_jam)}
                    </td>

                    <td class="px-5 py-4">
                        <p class="font-bold text-slate-950">${escapeHtml(item.uraian)}</p>
                        <p class="mt-1 text-xs text-slate-400">Transaksi ID ${escapeHtml(item.id)}</p>
                    </td>

                    <td class="px-5 py-4">
                        <span class="rounded-full px-3 py-1 text-xs font-bold ${isIncome ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700'}">
                            ${isIncome ? 'Pemasukan' : 'Pengeluaran'}
                        </span>
                    </td>

                    <td class="whitespace-nowrap px-5 py-4 text-right font-black ${isIncome ? 'text-emerald-600' : 'text-red-600'}">
                        ${isIncome ? '+' : '-'} ${rupiah(nominal)}
                    </td>
                </tr>
            `
            }).join('')

            el.detailPemasukan.textContent = rupiah(pemasukan)
            el.detailPengeluaran.textContent = rupiah(pengeluaran)
            el.detailSaldo.textContent = rupiah(pemasukan - pengeluaran)
        }

        async function loadAll(forceRender = false) {
            if (isLoading) return

            isLoading = true

            try {
                setStatus('Sinkronisasi...', 'warning')
                el.syncBar.style.width = '35%'

                await loadSummary()
                el.syncBar.style.width = '72%'

                await loadBackupList(forceRender)
                el.syncBar.style.width = '100%'

                setStatus('Realtime aktif', 'success')

                // if (forceRender) {
                //     showToast('Data berhasil disinkronkan')
                // }

                setTimeout(() => {
                    el.syncBar.style.width = '65%'
                }, 500)
            } catch (error) {
                console.error(error)
                setStatus('API bermasalah', 'error')
                el.syncBar.style.width = '20%'
            } finally {
                isLoading = false
            }
        }

        function startRealtime() {
            if (!window.Echo) {
                console.error('window.Echo belum tersedia. Periksa resources/js/app.js dan urutan Vite.')
                setStatus('Echo belum siap', 'error')
                return
            }

            window.Echo.channel('backup-monitor')
                .listen('.backup.updated', function(event) {
                    console.log('Event backup.updated masuk:', event)
                    loadAll(true)
                })

            console.log('Subscribe channel backup-monitor berhasil')
        }

        el.searchBackup.addEventListener('input', function() {
            searchKeyword = this.value
            renderBackupList()
        })

        el.backupList.addEventListener('click', function(event) {
            const card = event.target.closest('.backup-card')

            if (!card) return

            const id = card.getAttribute('data-id')
            loadDetail(id, true)
        })

        loadAll(true)

        setTimeout(function() {
            startRealtime()
        }, 500)
    </script>
</body>

</html>
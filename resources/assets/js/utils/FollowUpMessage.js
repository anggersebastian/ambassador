const firstMessage = (arg) => {
    const district = arg.district ? arg.district : null
    
    const address = district ? `*Alamat Pengiriman*:${arg.penerima}, +${arg.phone}, ${arg.address}, ${arg.district},${arg.city},${arg.province} %0a` : ''
    const ongkir = arg.shipping_fee > 0 ?  `*Ongkir*: Rp ${arg.shipping_fee} %0a`: ''
    return `Hai kak *${arg.name}*, Perkenalkan saya Angger CS Dropy.id😊Pesanan Anda sudah kami Terima, Berikut rinciannya: %0a%0a*Nomor Invoice*:${arg.order_id}%0a*Produk*:${arg.product} %0a${address}*Harga Produk*: Rp ${arg.product_price} %0a*Biaya Transfer*: Rp 4.400 %0a${ongkir}*Kode Unik*: Rp ${arg.unique} %0a*Total Pembayaran*: Rp ${arg.total}  %0a%0aPesanan Anda akan kami Proses setelah Anda Lakukan Transfer sejumlah *Rp ${arg.total}*.Silahkan klik link berikut untuk menuju halaman pembayaran: https://dropy.id/thanks?order=${arg.invoice}`
}

const codMessage = (arg) => {
    const district = arg.district ? arg.district : null
    const address = district ? `*Alamat Pengiriman*:${arg.penerima}, +${arg.phone}, ${arg.address}, ${arg.district},${arg.city},${arg.province} %0a` : ''
    const ongkir = arg.shipping_fee > 0 ?  `*Ongkir*: Rp ${arg.shipping_fee} %0a*COD Fee*:Rp ${arg.cod_fee}%0a`: ''
    return `Hai kak *${arg.name}*, Perkenalkan saya Angger CS Dropy.id😊Pesanan Anda sudah kami Terima, Berikut rinciannya: %0a%0a*Produk*:${arg.product} %0a${address}*Harga Produk*: Rp ${arg.product_price} %0a${ongkir}*Total Pembayaran*: Rp ${arg.total}  %0a%0aPembayaran dilakukan setelah Barang Sampai (COD), Mohon siapkan pembayaran sejumlah *Rp ${arg.total}*`
}

const secondMessage = (arg) => {
    return `Jika sudah *Lakukan Pembayaran*, Jangan lupa Kirim Bukti Pembayarannya ya kak *${arg.name}*😊, %0a* Atau konfirmasi pembayaran nya di halaman  berikut : https://dropy.id/order-confirm?order=${arg.invoice}`
}

const thirdMessage = (arg) => {
    return `Pastikan semua data diatas sudah benar kak *${arg.name}*, Apakah data diatas sudah benar kak *${arg.name}* ?`
}

const fourtchMessage = (arg) => {
    return `Halo kak *${arg.name}*, Pesanan Anda sudah kami kirim, %0aBerikut nomor resi pengirimannya: *${arg.tracking_number}* %0a%0aKalau mau Lacak pesanan Anda, Silahkan Klik link dibawah ini: => https://www.ninjaxpress.co/id-id/tracking?id=${arg.tracking_number}`
}

const invoiceMessage = (arg) => {
    return `Halo kak *${arg.name}*, Pesanan Anda sudah kami proses, %0aBerikut invoice pemesanan anda: => https://dropy.importir.com/api/order/generate-pdf/${arg.crypt_invoice}%0aTerimaksh`
}

export default {
    firstMessage,
    codMessage,
    secondMessage,
    thirdMessage,
    fourtchMessage,
    invoiceMessage
}
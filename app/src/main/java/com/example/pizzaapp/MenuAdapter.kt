package com.example.pizzaapp

import android.content.Context
import android.graphics.BitmapFactory
import android.graphics.ColorSpace.Model
import android.view.*
import android.widget.Button
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.pizzaapp.response.menu.MenuResponse
import com.squareup.picasso.Picasso


class MenuAdapter(private val list: ArrayList<MenuResponse>) : RecyclerView.Adapter<MenuAdapter.MenuViewHolder>(){

    //val data = listOf("aaa","bbbb","cccc","dddd","eeee","ffff","gggg","hhhh")

    override fun getItemCount(): Int = list.size

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): MenuViewHolder {

        val layoutInflater = LayoutInflater.from(parent?.context)
        val cellForRow = layoutInflater.inflate(R.layout.cardview_menu, parent, false)

        return MenuViewHolder(cellForRow)
    }

    override fun onBindViewHolder(holder: MenuViewHolder, position: Int) {

        holder.bind(list[position])

    }

    inner class MenuViewHolder(v:View):RecyclerView.ViewHolder(v) {
        val textNama:TextView
        val textId:TextView
        val textHarga:TextView
        val imgMenu:ImageView
        val btnAdd:Button

        init {
            textNama = v.findViewById(R.id.textNamaMenu)
            textId = v.findViewById(R.id.textViewId)
            textHarga = v.findViewById(R.id.textHargaMenu)
            imgMenu = v.findViewById(R.id.imageMenu)
            btnAdd = v.findViewById(R.id.buttonTambah)
        }

        fun bind(menuResponse: MenuResponse){
            val id:String = "${menuResponse.id_makanan}"
            val nama:String = "${menuResponse.nama_makanan}"
            val harga:String = "${menuResponse.harga}"
            val gambar:String = "${menuResponse.gambar}"

            textId.text = id
            textNama.text = nama
            textHarga.text = harga

            //val bmImg = BitmapFactory.decodeFile(gambar)
            //imgMenu.setImageBitmap(bmImg)

            //Picasso.get().load("http://192.168.100.10:70/rest_api/foto/American%20Beef.png").into(imgMenu)
            Picasso.get().load(gambar).into(imgMenu)

            btnAdd.setOnClickListener {
                TransaksiAdapter.jumlah = TransaksiAdapter.listId.count()
                TransaksiAdapter.listId += id
                TransaksiAdapter.listNama += nama
                TransaksiAdapter.listHarga += harga
                TransaksiAdapter.listFoto += gambar
                TransaksiAdapter.harga = TransaksiAdapter.harga + harga.toInt()
            }
        }
    }


}
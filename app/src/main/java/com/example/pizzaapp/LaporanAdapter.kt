package com.example.pizzaapp

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.pizzaapp.response.laporanresponse.LaporanResponse
import java.text.NumberFormat
import java.util.*
import kotlin.collections.ArrayList

class LaporanAdapter(private val list: ArrayList<LaporanResponse>) : RecyclerView.Adapter<LaporanAdapter.LaporanViewHolder>() {

    override fun getItemCount(): Int = list.size

    override fun onCreateViewHolder(
        parent: ViewGroup,
        viewType: Int
    ): LaporanAdapter.LaporanViewHolder {
        val layoutInflater = LayoutInflater.from(parent?.context)
        val cellForRow = layoutInflater.inflate(R.layout.cardview_report, parent, false)

        return LaporanViewHolder(cellForRow)
    }

    override fun onBindViewHolder(holder: LaporanViewHolder, position: Int) {
        holder.bind(list[position])
    }

    inner class LaporanViewHolder(v:View): RecyclerView.ViewHolder(v) {
        val textTanggal:TextView
        val textTotal:TextView

        init {
            textTanggal = v.findViewById(R.id.textTanggalReport)
            textTotal = v.findViewById(R.id.textTotalReport)
        }

        fun bind(laporanResponse: LaporanResponse) {

            val tanggal = "${laporanResponse.tanggal}"
            val total = "Rp ${laporanResponse.total}"

            textTanggal.text = tanggal
            textTotal.text = total
        }
    }
}
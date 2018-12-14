package Adapter;

import android.content.Intent;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.example.mochnirwanfirdaus.beautifulmalang.LayarDetailBiro;
import com.example.mochnirwanfirdaus.beautifulmalang.R;

import java.util.List;

import Model.Biro;

public class MyAdapter extends RecyclerView.Adapter<MyAdapter.MyViewHolder> {

    List<Biro> mBiroList;

    public MyAdapter(List<Biro> biroList) {
        mBiroList = biroList;
    }

    @Override
    public MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View mView = LayoutInflater.from(parent.getContext()).inflate(R.layout.list_item_biro,parent,false);
        MyViewHolder mViewHolder = new MyViewHolder(mView);
        return mViewHolder;
    }

    @Override
    public void onBindViewHolder(MyViewHolder holder, final int position) {
        holder.mTextViewIdBiro.setText("Id Biro :  " + mBiroList.get(position).getId_biro());
        holder.mTextViewIdKecamatan.setText("Id Kecamatan :  " + mBiroList.get(position).getId_kecamatan());
        holder.mTextViewNamaBiro.setText("Nama Biro :  " + mBiroList.get(position).getNama_biro());
        holder.mTextViewAlamat.setText("Alamat :  " + mBiroList.get(position).getAlamat());
        holder.mTextViewCp.setText("CP :  " + String.valueOf(mBiroList.get(position).getCp()));
        holder.mTextViewWisata.setText("Wisata :  " + mBiroList.get(position).getWisata());

        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent mIntent = new Intent(view.getContext(), LayarDetailBiro.class);
                mIntent.putExtra("id_biro",String.valueOf(mBiroList.get(position).getId_biro()));
                mIntent.putExtra("id_kec",String.valueOf(mBiroList.get(position).getId_kecamatan()));
                mIntent.putExtra("nama_biro",mBiroList.get(position).getNama_biro());
                mIntent.putExtra("alamat",mBiroList.get(position).getAlamat());
                mIntent.putExtra("cp",mBiroList.get(position).getCp());
                mIntent.putExtra("wisata",String.valueOf(mBiroList.get(position).getWisata()));
                view.getContext().startActivity(mIntent);
            }
        });

//        holder.itemView.setOnClickListener(new View.OnClickListener() {
//            @Override
//            public void onClick(View view) {
//                Intent mIntent = new Intent(view.getContext(), LayarDetail.class);
//                mIntent.putExtra("id_biro",mBiroList.get(position).getId_biro());
//                mIntent.putExtra("id_kecamatan",mBiroList.get(position).getId_kecamatan());
//                mIntent.putExtra("nama_biro",mBiroList.get(position).getNama_biro());
//                mIntent.putExtra("alamat",mBiroList.get(position).getAlamat());
//                mIntent.putExtra("cp",String.valueOf(mBiroList.get(position).getCp()));
//                mIntent.putExtra("wisata",mBiroList.get(position).getWisata());
//                view.getContext().startActivity(mIntent);
//            }
//        });
    }

    @Override
    public int getItemCount() {
        return mBiroList.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        public TextView mTextViewIdBiro, mTextViewIdKecamatan, mTextViewNamaBiro, mTextViewAlamat , mTextViewCp, mTextViewWisata;
        public MyViewHolder(View itemView) {
            super(itemView);
            mTextViewIdBiro = (TextView) itemView.findViewById(R.id.tvIdBiro);
            mTextViewIdKecamatan = (TextView) itemView.findViewById(R.id.tvIdKecamatan);
            mTextViewNamaBiro = (TextView) itemView.findViewById(R.id.tvNamaBiro);
            mTextViewAlamat = (TextView) itemView.findViewById(R.id.tvAlamat);
            mTextViewCp = (TextView) itemView.findViewById(R.id.tvCp);
            mTextViewWisata = (TextView) itemView.findViewById(R.id.tvWisata);
        }
    }
}

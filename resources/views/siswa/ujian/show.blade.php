@extends('template.main')
@section('content')

    <!--  BEGIN CONTENT AREA  -->
    <div class="content p-4 pb-0 d-flex flex-column-fluid position-relative">
        <div class="container-fluid px-0">
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="">{{ $ujian->nama }}</h5>
                        </div>
                        <div class='card-body'>
                            <table class="mt-2">
                                <tr>
                                    <th>Kelas</th>
                                    <th>: {{ $ujian->kelas->nama_kelas }}</th>
                                </tr>
                                <tr>
                                    <th>Mapel</th>
                                    <th>: {{ $ujian->mapel->nama_mapel }}</th>
                                </tr>
                                <tr>
                                    <th>Jumlah Soal</th>
                                    <th>: {{ $ujian->detailujian->count() }} Soal</th>
                                </tr>
                                <tr>
                                    <th>Waktu Ujian</th>
                                    <th>: {{ $ujian->jam }} Jam {{ $ujian->menit }} Menit</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @if ($waktu_ujian->selesai === null)    
                <div class="row mt-3">
                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-body">
                                <form id="examwizard-question" action="{{ url("/siswa/ujian") }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="kode" value="{{ $ujian->kode }}">
                                    <div class="">
                                        <div class="d-flex float-right">
                                            <div class="" style="font-size: 18px; font-weight: bold;"><span data-feather="clock"></span> | <span class="jam_skrng text-dark">00 : 00 : 00</span></div>
                                        </div>
                                        <div>
                                            @php
                                                $no = 1;
                                                $soal_hidden = '';
                                            @endphp
                                            @foreach ($pg_siswa as $soal)
                                                <div class="question {{ $soal_hidden }} question-{{ $no }}" data-question="{{ $no }}">
                                                    <div class=" pl-2 pt-2" style="border-bottom: 1px solid #e0e6ed;">
                                                        <div class="">
                                                            <h6 class="" style="font-weight: bold">Soal No. <span
                                                                    class=" no-soal" style="font-size: 1rem">{{ $no }}</span>
                                                            </h6>
                                                        </div>
                                                    </div>
        
                                                    <div class=" p-3 mt-3">
                                                        <div class="" style="border-bottom: 1px solid #e0e6ed;">
                                                            <h6 class="question-title color-green" style="word-wrap: break-word">
                                                                @if ($soal->detailujian->gambar != null)
                                                                <img src="{{url('public/_assets/file-ujian/')}}/{{ $soal->detailujian->gambar}}" width="200px" class="mb-3" alt="">
                                                                @endif
                                                                {!! $soal->detailujian->soal !!}
                                                                {{-- @php
                                                                    echo ($soal->detailujian->file);
                                                                @endphp --}}
                                                                @if ($soal->detailujian->file != null)
                                                                    
                                                                <hr>
                                                                <audio controls>
                                                                    <source src="{{url('public/_assets/file-ujian/')}}/{{ $soal->detailujian->file}}"/>
                                                                    browsermu tidak support audio
                                                                </audio>
                                                                @endif
                                                            </h6>
                                                        </div>
                                                        <div class=" mt-3" style="position: relative;">
                                                            <div class="alert alert-danger hidden"></div>
                                                            <div class="timer-check hidden" style="position: absolute; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.5);">
                                                                <h5 style="display: flex; justify-content: center; align-items: center; margin-top: 60px;">
                                                                    <span class="badge badge-danger text-dark">Waktu Habis!</span>
                                                                </h5>
                                                            </div>
                                                            <div class="green-radio color-green">
                                                                <ol type="A" style="color: #000; margin-left: -20px;">
                                                                    <li class="answer-number">
                                                                        <input type="radio" data-alternatetype="radio" name="{{ $soal->detailujian->id }}" value="{{ substr($soal->detailujian->pg_1, 0, 1) }}" id="soal{{ $no }}-{{ substr($soal->detailujian->pg_1, 0 ,1) }}" data-pg_siswa="{{ $soal->id }}" data-noSoal="{{ $no }}" @if($soal->jawaban == substr($soal->detailujian->pg_1, 0 ,1)) checked @endif/>
                                                                        <label for="soal{{ $no }}-{{ substr($soal->detailujian->pg_1, 0, 1) }}" class="answer-text" style="color: #000;">
                                                                            <span>{{ substr($soal->detailujian->pg_1, 3, strlen($soal->detailujian->pg_1)) }}</span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="answer-number">
                                                                        <input type="radio" data-alternatetype="radio" name="{{ $soal->detailujian->id }}" value="{{ substr($soal->detailujian->pg_2, 0, 1) }}" id="soal{{ $no }}-{{ substr($soal->detailujian->pg_2, 0 ,1) }}" data-pg_siswa="{{ $soal->id }}" data-noSoal="{{ $no }}" @if($soal->jawaban == substr($soal->detailujian->pg_2, 0 ,1)) checked @endif/>
                                                                        <label for="soal{{ $no }}-{{ substr($soal->detailujian->pg_2, 0, 1) }}" class="answer-text" style="color: #000;">
                                                                            <span>{{ substr($soal->detailujian->pg_2, 3, strlen($soal->detailujian->pg_2)) }}</span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="answer-number">
                                                                        <input type="radio" data-alternatetype="radio" name="{{ $soal->detailujian->id }}" value="{{ substr($soal->detailujian->pg_3, 0, 1) }}" id="soal{{ $no }}-{{ substr($soal->detailujian->pg_3, 0 ,1) }}" data-pg_siswa="{{ $soal->id }}" data-noSoal="{{ $no }}" @if($soal->jawaban == substr($soal->detailujian->pg_3, 0 ,1)) checked @endif/>
                                                                        <label for="soal{{ $no }}-{{ substr($soal->detailujian->pg_3, 0, 1) }}" class="answer-text" style="color: #000;">
                                                                            <span>{{ substr($soal->detailujian->pg_3, 3, strlen($soal->detailujian->pg_3)) }}</span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="answer-number">
                                                                        <input type="radio" data-alternatetype="radio" name="{{ $soal->detailujian->id }}" value="{{ substr($soal->detailujian->pg_4, 0, 1) }}" id="soal{{ $no }}-{{ substr($soal->detailujian->pg_4, 0 ,1) }}" data-pg_siswa="{{ $soal->id }}" data-noSoal="{{ $no }}" @if($soal->jawaban == substr($soal->detailujian->pg_4, 0 ,1)) checked @endif/>
                                                                        <label for="soal{{ $no }}-{{ substr($soal->detailujian->pg_4, 0, 1) }}" class="answer-text" style="color: #000;">
                                                                            <span>{{ substr($soal->detailujian->pg_4, 3, strlen($soal->detailujian->pg_4)) }}</span>
                                                                        </label>
                                                                    </li>
                                                                    <li class="answer-number">
                                                                        <input type="radio" data-alternatetype="radio" name="{{ $soal->detailujian->id }}" value="{{ substr($soal->detailujian->pg_5, 0, 1) }}" id="soal{{ $no }}-{{ substr($soal->detailujian->pg_5, 0 ,1) }}" data-pg_siswa="{{ $soal->id }}" data-noSoal="{{ $no }}" @if($soal->jawaban == substr($soal->detailujian->pg_5, 0 ,1)) checked @endif/>
                                                                        <label for="soal{{ $no }}-{{ substr($soal->detailujian->pg_5, 0, 1) }}" class="answer-text" style="color: #000;">
                                                                            <span>{{ substr($soal->detailujian->pg_5, 3, strlen($soal->detailujian->pg_5)) }}</span>
                                                                        </label>
                                                                    </li>
                                                                </ol>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                </div>
        
                                                @php
                                                    $soal_hidden = 'hidden';
                                                    $no++;
                                                @endphp
                                            @endforeach
                                        </div>
                                        <!-- SOAL -->
        
                                        <input type="hidden" value="1" id="currentQuestionNumber" name="currentQuestionNumber" />
                                        <input type="hidden" value="{{ $ujian->detailujian->count() }}" id="totalOfQuestion"
                                            name="totalOfQuestion" />
                                        <input type="hidden" value="[]" id="markedQuestion" name="markedQuestions" />
                                        <!-- END SOAL -->
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Exmas Footer - Multi Step Pages Footer -->
                        <div class="row">
                            <div class="col-lg-12 exams-footer">
                                <div class="row pb-3">
                                    <div class="col-sm-1 back-to-prev-question-wrapper text-center mt-3">
                                        <a href="javascript:void(0);" id="back-to-prev-question" class="btn btn-primary disabled">
                                            Back
                                        </a>
                                    </div>

                                    <div class="col-sm-2 footer-question-number-wrapper text-center mt-3">
                                        <div>
                                            <span id="current-question-number-label">1</span>
                                            <span>Dari <b>{{ $ujian->detailujian->count() }}</b></span>
                                        </div>
                                        <div>
                                            Nomor Soal
                                        </div>
                                    </div>
                                    <div class="col-sm-1 go-to-next-question-wrapper text-center mt-3">
                                        <a href="javascript:void(0);" id="go-to-next-question" class="btn btn-primary">
                                            Next
                                        </a>
                                    </div>

                                    <div class="col-sm-3 text-center mt-3 ragu-container">
                                        @php
                                            $no = 1;
                                            $hidden = '';
                                        @endphp
                                        @foreach ($pg_siswa as $soal)
                                            <div class="question {{ $hidden }} question-{{ $no }} ragus ragus-{{ $no }}" data-question="{{ $no }}">
                                                <a href="javascript:void(0);" class="btn btn-warning">
                                                    <input type="checkbox" class="ragu" id="ragu{{ $soal->detailujian->id }}" data-id_pg="{{ $soal->id }}" data-mark_name="{{ $soal->detailujian->id }}" data-question="{{ $no }}" @if($soal->ragu !== null ) checked @endif>
                                                    <label for="ragu{{ $soal->detailujian->id }}" class="mb-0 text-white">Ragu - Ragu</label>
                                                </a>
                                            </div>
                                            @php
                                                $no++;
                                                $hidden = 'hidden';
                                            @endphp
                                        @endforeach
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-3" id="quick-access-section" class="table-responsive">
                        <div class="card">
                            <div class="card-header pl-2 pt-2" style="border-bottom: 1px solid #e0e6ed;">
                                <h6 style="font-weight: bold;">Nomor Soal</h6>
                            </div>
                            <div class="card-body">
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($pg_siswa as $soal)
                                <div class="question-response-rows d-inline" data-question="{{ $no }}">
                                    <button class="btn @if($soal->ragu == null && $soal->jawaban == null) btn-white @endif shadow mt-2 question-response-rows-value @if($soal->jawaban !== null ) btn-info @endif @if($soal->ragu !== null ) btn-warning @endif" id="soalId{{ $soal->detailujian->id }}" style="width: 40px; height: 40px; font-weight: bold;">
                                        {{ $no }}
                                    </button>
                                </div>
                                @php
                                    $no++;
                                @endphp
                                @endforeach
                                <div class="mt-3">
                                    <span class="badge badge-info text-info" style="padding: 0px 6px;">-</span> = Sudah dikerjakan
                                    <br>
                                    <span class="badge badge-warning text-warning" style="padding: 0px 6px;">-</span> = Ragu - Ragu
                                    <br>
                                    <span class="badge btn-white" style="color: #cacaca; padding: 0px 6px;">-</span> = Belum dikerjakan
                                </div>
                            </div>
                        </div>
                        <div class="widget shadow p-3 mt-3">
                            <button class="btn btn-primary btn-block kirim-jawaban">Kirim Jawaban</button>
                        </div>
                    </div>

                </div>
            @else
                <div class="row">
                    <div class="col-lg-9">
                        <form id="examwizard-question" action="#" method="POST">
                            <div class="widget shadow p-2">
                                <div class="d-flex float-right">
                                    <div class="" style="font-size: 14px; font-weight: bold;">ujian selesai</div>
                                </div>
                                <div>
                                    @php
                                        $no = 1;
                                        $soal_hidden = '';
                                    @endphp
                                    @foreach ($pg_siswa as $soal)
                                        <div class="question {{ $soal_hidden }} question-{{ $no }}" data-question="{{ $no }}">
                                            <div class="widget-heading pl-2 pt-2" style="border-bottom: 1px solid #e0e6ed;">
                                                <div class="">
                                                    <h6 class="" style="font-weight: bold">Soal No. <span
                                                            class=" no-soal" style="font-size: 1rem">{{ $no }}</span>
                                                    </h6>
                                                </div>
                                            </div>

                                            <div class="widget p-3 mt-3">
                                                <div class="widget-heading" style="border-bottom: 1px solid #e0e6ed;">
                                                    <h6 class="question-title color-green" style="word-wrap: break-word">
                                                        @if ($soal->detailujian->gambar != null)
                                                        <img src="{{url('public/_assets/file-ujian/')}}/{{ $soal->detailujian->gambar}}" width="200px" class="mb-3" alt="">
                                                        @endif
                                                        {!! $soal->detailujian->soal !!}
                                                    </h6>
                                                    @if ($soal->detailujian->file != null)        
                                                        <hr>
                                                        <audio controls>
                                                            <source src="{{url('public/_assets/file-ujian/')}}/{{ $soal->detailujian->file}}"/>
                                                            browsermu tidak support audio
                                                        </audio>
                                                    @endif
                                                </div>
                                                <div class="widget-content mt-3">
                                                    <div class="alert alert-danger hidden"></div>
                                                    <div class="green-radio color-green">
                                                        <ol type="A" style="color: #000; margin-left: -20px;">
                                                            <li class="answer-number">
                                                                <label for="soal{{ $no }}-{{ substr($soal->detailujian->pg_1, 0, 1) }}" class="answer-text" style="color: #000;">
                                                                    <span>{{ substr($soal->detailujian->pg_1, 3, strlen($soal->detailujian->pg_1)) }}</span>
                                                                </label>
                                                            </li>
                                                            <li class="answer-number">
                                                                <label for="soal{{ $no }}-{{ substr($soal->detailujian->pg_2, 0, 1) }}" class="answer-text" style="color: #000;">
                                                                    <span>{{ substr($soal->detailujian->pg_2, 3, strlen($soal->detailujian->pg_2)) }}</span>
                                                                </label>
                                                            </li>
                                                            <li class="answer-number">
                                                                <label for="soal{{ $no }}-{{ substr($soal->detailujian->pg_3, 0, 1) }}" class="answer-text" style="color: #000;">
                                                                    <span>{{ substr($soal->detailujian->pg_3, 3, strlen($soal->detailujian->pg_3)) }}</span>
                                                                </label>
                                                            </li>
                                                            <li class="answer-number">
                                                                <label for="soal{{ $no }}-{{ substr($soal->detailujian->pg_4, 0, 1) }}" class="answer-text" style="color: #000;">
                                                                    <span>{{ substr($soal->detailujian->pg_4, 3, strlen($soal->detailujian->pg_4)) }}</span>
                                                                </label>
                                                            </li>
                                                            <li class="answer-number">
                                                                <label for="soal{{ $no }}-{{ substr($soal->detailujian->pg_5, 0, 1) }}" class="answer-text" style="color: #000;">
                                                                    <span>{{ substr($soal->detailujian->pg_5, 3, strlen($soal->detailujian->pg_5)) }}</span>
                                                                </label>
                                                            </li>
                                                        </ol>
                                                    </div>

                                                    <div class="mt-2" style="font-weight: bold;">
                                                        Jawaban Kamu : 
                                                        @if($soal->jawaban === null) tidak dijawab @endif 
                                                        @if($soal->jawaban !== null) {{ $soal->jawaban }} @endif 
                                                        @if($soal->benar == '1') <span class="badge badge-success ml-1 text-dark">benar</span> @endif 
                                                        @if($soal->benar == '0') <span class="badge badge-danger ml-1 text-dark">salah</span> @endif
                                                        @if($soal->ragu == '1') <span class="badge badge-warning text-dark">Ragu - Ragu</span> @endif
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        @php
                                            $soal_hidden = 'hidden';
                                            $no++;
                                        @endphp
                                    @endforeach
                                </div>
                                <!-- SOAL -->

                                <input type="hidden" value="1" id="currentQuestionNumber" name="currentQuestionNumber" />
                                <input type="hidden" value="{{ $ujian->detailujian->count() }}" id="totalOfQuestion"
                                    name="totalOfQuestion" />
                                <input type="hidden" value="[]" id="markedQuestion" name="markedQuestions" />
                                <!-- END SOAL -->
                                @php
                                    $salah = 0;
                                    $benar = 0;
                                    $tidakDijawab = 0;
                                @endphp
                                @foreach ($pg_siswa as $soal)
                                    @if ($soal->benar == '0')
                                        @php $salah++ @endphp
                                    @endif
                                    @if ($soal->benar == '1')
                                        @php $benar++ @endphp
                                    @endif
                                    @if ($soal->benar === null)
                                        @php $tidakDijawab++ @endphp
                                    @endif
                                @endforeach
                                <div class="widget-footer pl-2 py-2 mt-3" style="border-top: 1px solid #e0e6ed; font-weight: bold;">
                                    Hasil Ujian
                                    <div class="table-responsive" style="overflow-x: scroll;">
                                        <table class="text-nowrap">
                                            @php
                                                $total_soal_pg = $ujian->detailujian->count();
                                                $nilai = ($benar / $total_soal_pg) * 100;
                                            @endphp
                                            <tr>
                                                <th>Benar : <span class="badge badge-success mr-1 mt-1 text-dark">{{ $benar }}</span> | Salah : <span class="badge badge-danger mr-1 mt-1 text-dark">{{ $salah }}</span> | Tidak Dijawab : <span class="badge btn-white mt-1 text-dark">{{ $tidakDijawab }}</span> | Nilai : <span class="badge badge-primary text-dark">{{ round($nilai) }} / 100</span></th>
                                            </tr>
                                        </table>
                                    </div>
                                    {{-- <table>
                                        <tr>
                                            <th>Benar</th>
                                            <th>: <span class="badge badge-success mr-1 mt-1">{{ $benar }}</span></th>
                                        </tr>
                                        <tr>
                                            <th>Salah</th>
                                            <th>: <span class="badge badge-danger mr-1 mt-1">{{ $salah }}</span></th>
                                        </tr>
                                        <tr>
                                            <th>Tidak Dijawab</th>
                                            <th>: <span class="badge btn-white mt-1">{{ $tidakDijawab }}</span></th>
                                        </tr>
                                        <tr>
                                            <th>Nilai Ujian</th>
                                            @php
                                                $total_soal_pg = $ujian->detailujian->count();
                                                $nilai = ($benar / $total_soal_pg) * 100;
                                            @endphp
                                            <th>: {{ round($nilai) }}</th>
                                        </tr>
                                    </table> --}}
                                    {{-- Benar : <span class="badge badge-success mr-1 mt-1">{{ $benar }}</span><br>  
                                    Salah : <span class="badge badge-danger mr-1 mt-1">{{ $salah }}</span><br> 
                                    Tidak dijawab : <span class="badge btn-white">{{ $tidakDijawab }}</span> --}}
                                </div>

                            </div>
                        </form>

                        <!-- Exmas Footer - Multi Step Pages Footer -->
                        <div class="row">
                            <div class="col-lg-12 exams-footer">
                                <div class="row pb-3">
                                    <div class="col-sm-1 back-to-prev-question-wrapper text-center mt-3">
                                        <a href="javascript:void(0);" id="back-to-prev-question" class="btn btn-primary disabled">
                                            Back
                                        </a>
                                    </div>

                                    <div class="col-sm-2 footer-question-number-wrapper text-center mt-3">
                                        <div>
                                            <span id="current-question-number-label">1</span>
                                            <span>Dari <b>{{ $ujian->detailujian->count() }}</b></span>
                                        </div>
                                        <div>
                                            Nomor Soal
                                        </div>
                                    </div>
                                    <div class="col-sm-1 go-to-next-question-wrapper text-center mt-3">
                                        <a href="javascript:void(0);" id="go-to-next-question" class="btn btn-primary">
                                            Next
                                        </a>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-3" id="quick-access-section" class="table-responsive">
                        <div class="widget shadow p-3">
                            <div class="widget-heading pl-2 pt-2" style="border-bottom: 1px solid #e0e6ed;">
                                <h6 style="font-weight: bold;">Nomor Soal</h6>
                            </div>
                            <div class="widget-content">
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($pg_siswa as $soal)
                                <div class="question-response-rows d-inline" data-question="{{ $no }}">
                                    <button class="btn @if($soal->ragu == null && $soal->jawaban == null) btn-white @endif shadow mt-2 question-response-rows-value @if($soal->jawaban !== null ) btn-info @endif @if($soal->ragu !== null ) btn-warning @endif" id="soalId{{ $soal->detailujian->id }}" style="width: 40px; height: 40px; font-weight: bold;">
                                        {{ $no }}
                                    </button>
                                </div>
                                @php
                                    $no++;
                                @endphp
                                @endforeach
                                <div class="mt-3">
                                    <span class="badge badge-info text-info" style="padding: 0px 6px;">-</span> = Sudah dikerjakan
                                    <br>
                                    <span class="badge badge-warning text-warning" style="padding: 0px 6px;">-</span> = Ragu - Ragu
                                    <br>
                                    <span class="badge btn-white" style="color: #cacaca; padding: 0px 6px;">-</span> = Belum dikerjakan
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endif

        </div>
        {{-- @include('template.footer') --}}
    </div>
    <!--  END CONTENT AREA  -->
    {!! session('pesan') !!}
    @include('error.ew-s-p')
@endsection

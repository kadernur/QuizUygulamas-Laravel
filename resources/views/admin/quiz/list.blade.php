<x-app-layout>
    <x-slot name="header"> Quizzes</x-slot>

  <div class="card">
    <div class="card-body">
        <h5 class="card-title">
            <a href="{{route('quizzes.create')}}" class="btn btn-sm btn-primary float-right">
              <i class="fa fa-plus"></i> Create Quiz</a>
        </h5>
        {{-- Veri filtreleme --}}
        <form method="GET" action="">
          <div class="form-row">

             <div class="col-md-2">
               <input type="text" name="title" value="{{request()->get('title')}}" placeholder="Quiz Name" class="form-control">
             </div>

             <div class="col-md-2">
               <select class="form-control" onchange="this.form.submit()" name="status">
                 <option  value="">Please Select Status</option>
                 <option @if(request()->get('status')== 'publish') selected @endif value="published">Active</option>
                 <option @if(request()->get('status')=='passive') selected @endif value="passive">Passive</option>
                 <option @if(request()->get('status')=='draft') selected @endif value="draft">Draft</option>
 

               </select>

             </div>

              @if(request()->get('title') || request()->get('status'))
                  <div class="col-md-2">
                      <a href="{{route('quizzes.index')}}" class="btn btn-secondary ">Reset</a>


                  </div>
              @endif


          </div>



      </form>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">Quiz</th>
              <th scope="col">Number of Questions</th>
              <th scope="col">Status</th>
              <th scope="col">Finished at</th>
              <th scope="col">Transactions</th>

            </tr>
          </thead>
          <tbody>
            @foreach($quizzes as $quiz)
            <tr>
              <td >{{ $quiz->title }}</td>
              <td >{{ $quiz->questions_count }}</td>
             <td>{{ $quiz->status}}</td>

             <td>
              <span title="{{$quiz->finished_at}}">{{$quiz->finished_at ? $quiz->finished_at->diffForHumans() : '-'}}</span>
             </td>
             <td><a href="{{route('questions.index',$quiz->id)}}" class="btn btn-sm btn-warning">
              <i class="fa fa-question"></i>
            </a>
              <a href="{{route('quizzes.edit',$quiz->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>
              <a href="{{route('quizzes.destroy',$quiz->id)}}" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>


             </td>

            </tr>
            @endforeach
          </tbody>
          
        </table>
        {{$quizzes->withQueryString()->links()}}

    </div>
  </div>
</x-app-layout>

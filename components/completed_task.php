<?php

function completed_task($id, $name, $description) {
    return "<div class='row mt-2 '>
                <div class='col d-flex justify-content-center align-items-center'>
                    $name
                </div>
                <div class='col-6 d-flex justify-content-center align-items-center'>
                    $description
                </div>
                <div class='col d-flex justify-content-center align-items-center gap-1'>         
                        <button type='submit' class='btn btn-danger' name='delete-completed' value='$id'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                            <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                        </svg>
                    </button>
                </div>
            </div>  ";
}
<?php
namespace App\Services;

use App\DTO\BookDTO;
use App\DTO\LoanDTO;
use App\Enums\Status;
use App\Models\Loan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class LoanService
{
    public function create(LoanDTO $loanData): Loan
    {   
        $code = $this->generateCodeLoan();

        while (Loan::where('code', $code)->exists()) {
            $code = $this->generateCodeLoan();
        }

        $status = $loanData->loanDate->isToday() ? Status::LOANED : Status::RESERVED;

        $loan = Loan::create([
            'user_id' => $loanData->student->id,
            'book_id' => $loanData->book->id,
            'loaned_date' => $loanData->loanDate,
            'due_date' => $loanData->dueDate,
            'code' => $code,
            'status' => $status,
        ]);

        Mail::to($loanData->student->email)->send(new \App\Mail\BookLoanNotification($loan));

        return $loan;
    }

    public function edit(LoanDTO $loanData, Loan $loan): Loan
    {
        $loan->update([
            'user_id' => $loanData->student->id,
            'book_id' => $loanData->book->id,
            'loaned_date' => $loanData->loanDate,
            'due_date' => $loanData->dueDate,
        ]);

        return $loan->fresh();
    }

    private function generateCodeLoan(): string
    {
        return 'LN-' . Str::upper(Str::random(4));
    }

    public function return(Loan $loan, bool $isDue = false, array $returnData = []): Loan
    {
        $loan->update([
            'returned_date' => now(),
            'status' => $isDue ? Status::OVERDUE : Status::RETURNED,
            'fine_amount' => $returnData['fine_amount'] ?? 0.00
        ]);

        return $loan->fresh();
    }
}
# Observer

retrieved : after a record has been retrieved.
creating : before a record has been created.
created : after a record has been created.
updating : before a record is updated.
updated : after a record has been updated.
saving : before a record is saved (either created or updated).
saved : after a record has been saved (either created or updated).
deleting : before a record is deleted or soft-deleted.
deleted : after a record has been deleted or soft-deleted.
restoring : before a soft-deleted record is going to be restored.
restored : after a soft-deleted record has been restored.

# DB Transaction

DB::transaction(function() {
    // Do something and save to the db...
});

is the same as this:

// Open a try/catch block
try {
    // Begin a transaction
    DB::beginTransaction();

    // Do something and save to the db...

    // Commit the transaction
    DB::commit();
} catch (\Exception $e) {
    // An error occured; cancel the transaction...
    DB::rollback();
    
    // and throw the error again.
    throw $e;
}

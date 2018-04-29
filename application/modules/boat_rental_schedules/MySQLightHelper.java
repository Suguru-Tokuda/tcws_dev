package com.example.it354f715.login_q3;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

/**
 * Created by it354F715 on 10/20/2017.
 */

public class MySQLightHelper extends SQLiteOpenHelper {

    public static final String COLUMN_ID = "_id";
    public static final String USER_ID = "user_id";
    public static final String TABLE_USERS = "users";
    public static final String FIRST_NAME = "first_Name";
    public static final String LAST_NAME = "last_name";
    public static final String PASSWORD = "password";
    public static final String EMAIL = "email";
    public static final String SECURITY_QUESTION = "security_question";
    public static final String SECURITY_ANSWER = "security_answer";
    public static final String LOGIN_COUNT = "login_count";

    private static final String DATABASE_NAME = "logininfo.db";
    private static final int DATABASE_VERSION = 1;

    // Database creation sql statement
    private static final String DATABASE_CREATE =
            "CREATE TABLE IF NOT EXISTS " + TABLE_USERS
            + "(" + COLUMN_ID + " INTEGER PRIMARY KEY AUTOINCREMENT, " // 0
            + FIRST_NAME + " TEXT NOT NULL," // 1
            + LAST_NAME + " TEXT NOT NULL," // 2
            + USER_ID + " TEXT NOT NULL," // 3
            + EMAIL + " TEXT NOT NULL," // 4
            + PASSWORD + " TEXT NOT NULL," // 5
            + SECURITY_QUESTION + " TEXT NOT NULL," // 6
            + SECURITY_ANSWER + " TEXT NOT NULL," // 7
            + LOGIN_COUNT + " INTEGER NOT NULL)"; // 8

    public MySQLightHelper(Context context) {
        super(context, DATABASE_NAME, null, DATABASE_VERSION);
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        db.execSQL(DATABASE_CREATE);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        Log.v(MySQLightHelper.class.getName(),
                "Upgrading database from version " + oldVersion + " to "
        + newVersion + ", which will destroy all old data");
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_USERS);
        onCreate(db);
    }
}

import java.sql.*;

public class DatabaseConnection {
   
    private static String QUERY_1 = "SELECT cus.bdate, cus.address, cus.city FROM  customer as cus WHERE cus.wallet = (SELECT min(customer.wallet) FROM customer);";

    private static String QUERY_2 = "SELECT cus.cname FROM customer AS cus, product AS prod, buy AS b " +
    "WHERE cus.cid = b.cid" +
        " AND prod.pid = b.pid" +
        " AND b.pid IN (SELECT prod.pid FROM product AS prod WHERE prod.price < 10)" +
    " GROUP BY cus.cname" +
    " HAVING count(cname) = (SELECT count(*) FROM product AS prod WHERE prod.price < 10);";

    private static String QUERY_3 = "SELECT prod.pname" +
    " FROM product AS prod" +
    " WHERE 2 < (SELECT pid" +
    " FROM (SELECT pid, count(pid) " +
    " FROM buy" +
    " GROUP BY pid) AS PID_COUNT" +
    " WHERE prod.pid = PID_COUNT.pid);";

    private static String QUERY_4 = "SELECT prod.pname FROM product AS prod WHERE prod.price < (SELECT cus.wallet FROM customer AS cus WHERE cus.cid = (SELECT cusInner.cid" +
                                         " FROM customer AS cusInner" +
                                         " ORDER BY cusInner.bdate " +
                                         " LIMIT 1));";

    private static String QUERY_5 = "SELECT customer.cname FROM customer WHERE customer.cid = (SELECT cid FROM (SELECT cid, max(quantity) AS max FROM buy GROUP BY cid) AS TEMP ORDER BY max DESC LIMIT 0,1);";
    private static String[] QUERIES = {QUERY_1, QUERY_2, QUERY_3, QUERY_4, QUERY_5};

    private static final String DB_URL  = "jdbc:mysql://localhost/DatabasePA01";
    private static final String DB_USER = "coconatree";
    private static final String DB_PASS = "191200";

    private static final String TEST_QUERY = "SELECT * FROM product;";

    private final Connection connection;

    public DatabaseConnection() throws SQLException {
        this.connection = DriverManager.getConnection(DB_URL, DB_USER, DB_PASS);
    }

    private void ExecuteQuery(String query) throws SQLException {
        Statement statement = this.connection.createStatement();
        System.out.printf("Query: %s%n", query);
        ResultSet resultSet = statement.executeQuery(query);
        this.PrintResultSet(resultSet);
        statement.close();
    }

    private void PrintResultSet(ResultSet resultSet) throws SQLException {
        ResultSetMetaData metaData = resultSet.getMetaData();
        String columnName;
        while(resultSet.next()) {
            for(int i = 1; i <= metaData.getColumnCount(); i++) {
                columnName = metaData.getColumnName(i);
                System.out.printf("%s: %s ", columnName, resultSet.getObject(columnName).toString());
            }
            System.out.printf("%n");
        }
        System.out.printf("%n");
    }

    private void Close() throws SQLException {
        this.connection.close();
    }


    public static void main(String[] args) throws SQLException {
        DatabaseConnection databaseConnection = new DatabaseConnection();

        for (int i = 0; i < 5; i++) {
            databaseConnection.ExecuteQuery(QUERIES[i]);
        }
        databaseConnection.Close();
    }
}

<?php

	///////////////////////////////////////////////////
	// CHANGE THESE VALUES
	///////////////////////////////////////////////////

	define( 'DB_SERVER', 'localhost' );
	define( 'DB_USER',   'root2' );
	define( 'DB_PW',     'root' );
	define( 'DB_NAME',   'chinook' );

	///////////////////////////////////////////////////

	define( 'PARAM_NAME', 'artist_name' );

	$param = 'black%';
	if ( isset( $_GET[ PARAM_NAME ] ) )
	{
		$param = trim( $_GET[ PARAM_NAME ] );
		if ( empty( $param ) )
		{
			$param = null;
		}
	}

?>
<html>
	<head>
		<title>MySQL + Chinook Demo</title>
	<head>
	<body>
		<form method="GET" action="<?php echo htmlentities( $_SERVER['PHP_SELF'] ); ?>">
			Search for artist: <input type="text" name="<?PHP echo htmlentities( PARAM_NAME ); ?>" value="<?php echo htmlentities( ( is_null( $param ) )?( '' ):( $param ) ) ?>" />
			<input type="submit" />
		</form>

		<hr />

		<p>
			<b>DB Connection</b>:
			<?php
				$mysqli = new mysqli( DB_SERVER, DB_USER, DB_PW, DB_NAME );
				$connected = false;
				if ( $mysqli->connect_errno )
				{
					echo htmlentities( "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error );
				}
				else
				{
					echo htmlentities( 'Success!' );
					$connected = true;
				}
			?>
		</p>

		<?php
			if ( $connected )
			{
		?>

			<hr />

			<p>
				<b>SQL to Prepare</b>:
				<?php

					$sql = null;
					if ( is_null( $param ) )
					{
						$sql = 'SELECT art.Name AS art_name, alb.Title AS alb_title' .
							   ' FROM album alb INNER JOIN artist art ON alb.ArtistId=art.ArtistId' .
							   ' ORDER BY art_name ASC, alb_title ASC';
					}
					else
					{
						$sql = 'SELECT art.Name AS art_name, alb.Title AS alb_title' .
							   ' FROM artist art INNER JOIN album alb ON art.ArtistId=alb.ArtistId' .
							   ' WHERE art.Name LIKE ?' .
							   ' ORDER BY art_name ASC, alb_title ASC';
					}

					echo htmlentities( $sql );

				?>
			</p>

			<p>
				<b>Preparing</b>:
				<?php
					if ( !( $stmt = $mysqli->prepare( $sql ) ) )
					{
						echo htmlentities( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error );
					}
					else
					{
						echo 'Success!';
					}
				?>
			</p>

			<?php
				if ( !is_null( $param ) )
				{
			?>
				<p>
					<b>Binding parameter</b>:
					<?php
						if ( !$stmt->bind_param( "s", $param ) )
						{
							echo htmlentities( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error );
						}
						else
						{
							echo 'Success!';
						}
					?>
				</p>
			<?php
				}
			?>

			<p>
				<b>Executing</b>:
				<?php
					if ( !$stmt->execute() )
					{
						echo htmlentities( "Execute failed: (" . $stmt->errno . ") " . $stmt->error );
					}
					else
					{
						echo 'Success!';
					}
				?>
			</p>

			<p>
				<u><b>Results</b></u><br />
				<?php

					$artist_name = null;
					$album_name = null;
					$stmt->bind_result( $artist_name, $album_name );

					while ( $stmt->fetch() )
					{
						echo ( '&lt;' . htmlentities( $artist_name ) . '&gt; ' . htmlentities( $album_name ) );
						echo '<br />';
					}

					$stmt->close();

				?>
			</p>

			<hr />

			<p>
				<b>Manual SQL to Execute</b>:
				<?php

					$sql = null;
					if ( is_null( $param ) )
					{
						$sql = 'SELECT art.Name AS art_name, alb.Title AS alb_title' .
							   ' FROM album alb INNER JOIN artist art ON alb.ArtistId=art.ArtistId' .
							   ' ORDER BY art_name ASC, alb_title ASC';
					}
					else
					{
						$sql = 'SELECT art.Name AS art_name, alb.Title AS alb_title' .
							   ' FROM artist art INNER JOIN album alb ON art.ArtistId=alb.ArtistId' .
							   ' WHERE art.Name LIKE \'' . $mysqli->escape_string( $param ) . '\'' .
							   ' ORDER BY art_name ASC, alb_title ASC';
					}

					echo htmlentities( $sql );

				?>

			</p>

			<p>
				<b>Executing</b>:
				<?php
					$result = $mysqli->query( $sql );
					if ( !$result )
					{
						echo htmlentities( $mysqli->error );
					}
					else
					{
						echo 'Success!';
					}
				?>
			</p>

			<p>
				<b><u>Results</u></b><br />
				<?php
					while ( $arr = $result->fetch_array( MYSQLI_ASSOC ) )
					{
						echo ( '&lt;' . htmlentities( $arr['art_name'] ) . '&gt; ' . htmlentities( $arr['alb_title'] ) );
						echo '<br />';
					}
				?>
			</p>

			<hr />

			<p>
				<b>DB Disconnection</b>:
				<?php
					echo ( ( $mysqli->close() )?( 'Success!' ):( 'Failure!' ) );
				?>
			</p>

		<?php
			}
		?>

	</body>
</html>
